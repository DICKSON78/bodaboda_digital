<?php

namespace Tests\Feature;

use App\Models\Ride;
use App\Models\Rider;
use App\Models\User;
use App\Services\MqttService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class MqttPublishTest extends TestCase
{
    use RefreshDatabase;

    private int $passengerId;
    private int $riderUserId;
    private int $riderId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->passengerId = DB::table('users')->insertGetId([
            'name' => 'Test Passenger',
            'email' => 'passenger@mqtt.test',
            'password' => bcrypt('password'),
            'role' => 'passenger',
        ]);

        $this->riderUserId = DB::table('users')->insertGetId([
            'name' => 'Test Rider',
            'email' => 'rider@mqtt.test',
            'password' => bcrypt('password'),
            'role' => 'rider',
        ]);

        $this->riderId = DB::table('riders')->insertGetId([
            'user_id' => $this->riderUserId,
            'first_name' => 'Test',
            'last_name' => 'Rider',
            'phone_number' => '255712345678',
            'license_number' => 'LIC-MQTT',
            'bike_plate' => 'MC 100 XYZ',
            'status' => 'online',
            'is_approved' => true,
        ]);
    }

    private function makeRide(array $overrides = []): object
    {
        $id = DB::table('rides')->insertGetId(array_merge([
            'passenger_id' => $this->passengerId,
            'pickup_lat' => -6.1622,
            'pickup_lng' => 35.7516,
            'dest_lat' => -6.1722,
            'dest_lng' => 35.7616,
            'pickup_address' => 'City Center',
            'destination_address' => 'Airport',
            'fare' => 3000,
            'status' => 'requested',
            'ride_token' => Str::uuid(),
            'created_at' => now(),
            'updated_at' => now(),
        ], $overrides));

        return DB::table('rides')->find($id);
    }

    public function test_publishes_ride_request_on_create()
    {
        $this->actingAs(User::find($this->passengerId));

        $mqtt = $this->createMock(MqttService::class);
        $mqtt->expects($this->once())
            ->method('publish')
            ->with(
                'ride/request',
                $this->callback(fn($payload) =>
                    isset($payload['ride_id'])
                    && isset($payload['pickup'])
                    && isset($payload['destination'])
                    && isset($payload['fare'])
                    && isset($payload['distance'])
                )
            );
        $this->app->instance(MqttService::class, $mqtt);

        $this->post('/rides', [
            'pickup_lat' => -6.1622,
            'pickup_lng' => 35.7516,
            'dest_lat' => -6.1722,
            'dest_lng' => 35.7616,
            'pickup_address' => 'City Center',
            'destination_address' => 'Airport',
            'distance' => 2.5,
        ]);
    }

    public function test_publishes_accepted_with_ride_token_topic()
    {
        $this->actingAs(User::find($this->riderUserId));

        $ride = $this->makeRide();

        $expectedTopic = 'ride/status/' . $ride->id . '/' . $ride->ride_token;

        $mqtt = $this->createPartialMock(MqttService::class, ['publish', 'rideStatusTopic']);
        $mqtt->method('rideStatusTopic')->willReturn($expectedTopic);
        $mqtt->expects($this->once())
            ->method('publish')
            ->with(
                $expectedTopic,
                $this->callback(fn($payload) =>
                    isset($payload['status'])
                    && $payload['status'] === 'accepted'
                    && isset($payload['driver'])
                )
            );
        $this->app->instance(MqttService::class, $mqtt);

        $this->post(route('rides.accept', $ride->id));
    }

    public function test_publishes_ongoing_on_start()
    {
        $this->actingAs(User::find($this->riderUserId));

        $ride = $this->makeRide([
            'rider_id' => $this->riderId,
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        $expectedTopic = 'ride/status/' . $ride->id . '/' . $ride->ride_token;

        $mqtt = $this->createPartialMock(MqttService::class, ['publish', 'rideStatusTopic']);
        $mqtt->method('rideStatusTopic')->willReturn($expectedTopic);
        $mqtt->expects($this->once())
            ->method('publish')
            ->with(
                $expectedTopic,
                $this->callback(fn($payload) =>
                    isset($payload['status'])
                    && $payload['status'] === 'ongoing'
                )
            );
        $this->app->instance(MqttService::class, $mqtt);

        $this->post(route('rides.start', $ride->id));
    }

    public function test_publishes_completed_with_fare()
    {
        $this->actingAs(User::find($this->riderUserId));

        $ride = $this->makeRide([
            'rider_id' => $this->riderId,
            'status' => 'ongoing',
            'accepted_at' => now(),
            'trip_started_at' => now(),
            'fare' => 5000,
        ]);

        $expectedTopic = 'ride/status/' . $ride->id . '/' . $ride->ride_token;

        $mqtt = $this->createPartialMock(MqttService::class, ['publish', 'rideStatusTopic']);
        $mqtt->method('rideStatusTopic')->willReturn($expectedTopic);
        $mqtt->expects($this->once())
            ->method('publish')
            ->with(
                $expectedTopic,
                $this->callback(fn($payload) =>
                    $payload['status'] === 'completed'
                    && (int) $payload['fare'] === 5000
                )
            );
        $this->app->instance(MqttService::class, $mqtt);

        $this->post(route('rides.complete', $ride->id));
    }

    public function test_publishes_cancelled_status()
    {
        $this->actingAs(User::find($this->passengerId));

        $ride = $this->makeRide([
            'rider_id' => $this->riderId,
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        $expectedTopic = 'ride/status/' . $ride->id . '/' . $ride->ride_token;

        $mqtt = $this->createPartialMock(MqttService::class, ['publish', 'rideStatusTopic']);
        $mqtt->method('rideStatusTopic')->willReturn($expectedTopic);
        $mqtt->expects($this->once())
            ->method('publish')
            ->with(
                $expectedTopic,
                $this->callback(fn($payload) =>
                    $payload['status'] === 'cancelled'
                )
            );
        $this->app->instance(MqttService::class, $mqtt);

        $this->post(route('rides.cancel', $ride->id));
    }

    public function test_show_page_contains_token_based_mqtt_topics()
    {
        $ride = $this->makeRide([
            'rider_id' => $this->riderId,
            'status' => 'ongoing',
            'accepted_at' => now(),
            'trip_started_at' => now(),
        ]);

        $response = $this->get("/rides/{$ride->id}");

        $response->assertStatus(200);
        $response->assertSee('live-map', false);
        $response->assertSee('mqtt');
        $response->assertSee('statusTopic');
        $response->assertSee($ride->ride_token);
    }

    public function test_ride_has_unique_token()
    {
        $ride1 = $this->makeRide();
        $ride2 = $this->makeRide();

        $this->assertNotNull($ride1->ride_token);
        $this->assertNotNull($ride2->ride_token);
        $this->assertNotEquals($ride1->ride_token, $ride2->ride_token);
    }
}
