<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class RideLifecycleTest extends TestCase
{
    use RefreshDatabase;

    private int $passengerId;
    private int $riderUserId;
    private int $riderId;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class);

        $this->passengerId = DB::table('users')->insertGetId([
            'name' => 'Test Passenger',
            'email' => 'passenger@test.com',
            'password' => bcrypt('password'),
            'role' => 'passenger',
        ]);

        $this->riderUserId = DB::table('users')->insertGetId([
            'name' => 'Test Rider',
            'email' => 'rider@test.com',
            'password' => bcrypt('password'),
            'role' => 'rider',
        ]);

        $this->riderId = DB::table('riders')->insertGetId([
            'user_id' => $this->riderUserId,
            'first_name' => 'Test',
            'last_name' => 'Rider',
            'phone_number' => '255712345678',
            'license_number' => 'LIC-' . Str::random(6),
            'bike_plate' => 'MC ' . rand(100, 999) . ' XYZ',
            'status' => 'online',
            'is_approved' => true,
        ]);
    }

    public function test_ride_is_created_and_shows_on_show_page()
    {
        $response = $this->post('/rides', [
            'passenger_name' => 'Jane Doe',
            'passenger_phone' => '255712345679',
            'pickup_lat' => -6.1622,
            'pickup_lng' => 35.7516,
            'dest_lat' => -6.1722,
            'dest_lng' => 35.7616,
            'pickup_address' => 'City Center, Dodoma',
            'destination_address' => 'Nyerere Square, Dodoma',
            'distance' => 1.5,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('rides', [
            'pickup_lat' => -6.1622,
            'status' => 'requested',
        ]);

        $ride = DB::table('rides')->where('pickup_lat', -6.1622)->first();
        $this->assertNotNull($ride->ride_token);
        $this->assertEquals('requested', $ride->status);

        $showResponse = $this->get("/rides/{$ride->id}");
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Ride #' . $ride->id);
    }

    public function test_full_ride_lifecycle_via_database()
    {
        $rideId = DB::table('rides')->insertGetId([
            'passenger_id' => $this->passengerId,
            'pickup_lat' => -6.1622,
            'pickup_lng' => 35.7516,
            'dest_lat' => -6.1722,
            'dest_lng' => 35.7616,
            'pickup_address' => 'City Center, Dodoma',
            'destination_address' => 'Nyerere Square, Dodoma',
            'fare' => 3000,
            'status' => 'requested',
            'ride_token' => Str::uuid(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Accept ride via DB
        DB::table('rides')
            ->where('id', $rideId)
            ->update([
                'rider_id' => $this->riderId,
                'status' => 'accepted',
                'accepted_at' => now(),
            ]);

        $this->assertDatabaseHas('rides', [
            'id' => $rideId,
            'rider_id' => $this->riderId,
            'status' => 'accepted',
        ]);

        // Authenticate as rider for start/complete
        $this->actingAs(\App\Models\User::find($this->riderUserId));

        $startResponse = $this->post(route('rides.start', $rideId));
        $startResponse->assertStatus(302);

        $this->assertDatabaseHas('rides', [
            'id' => $rideId,
            'status' => 'ongoing',
        ]);

        $completeResponse = $this->post(route('rides.complete', $rideId));
        $completeResponse->assertStatus(302);

        $this->assertDatabaseHas('rides', [
            'id' => $rideId,
            'status' => 'completed',
        ]);
    }

    public function test_accept_completes_via_http_endpoints()
    {
        $rideId = DB::table('rides')->insertGetId([
            'passenger_id' => $this->passengerId,
            'pickup_lat' => -6.1622,
            'pickup_lng' => 35.7516,
            'dest_lat' => -6.1722,
            'dest_lng' => 35.7616,
            'pickup_address' => 'Market Street',
            'destination_address' => 'Bus Terminal',
            'fare' => 2500,
            'status' => 'requested',
            'ride_token' => Str::uuid(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs(\App\Models\User::find($this->riderUserId));

        // Accept returns JSON
        $acceptResponse = $this->post(route('rides.accept', $rideId));
        $acceptResponse->assertStatus(200);
        $acceptResponse->assertJson(['success' => true]);

        $this->assertDatabaseHas('rides', [
            'id' => $rideId,
            'rider_id' => $this->riderId,
            'status' => 'accepted',
        ]);

        // Start returns redirect
        $startResponse = $this->post(route('rides.start', $rideId));
        $startResponse->assertStatus(302);

        $this->assertDatabaseHas('rides', [
            'id' => $rideId,
            'status' => 'ongoing',
        ]);

        // Complete returns redirect
        $completeResponse = $this->post(route('rides.complete', $rideId));
        $completeResponse->assertStatus(302);

        $this->assertDatabaseHas('rides', [
            'id' => $rideId,
            'status' => 'completed',
        ]);
    }

    public function test_ride_cancellation_flow()
    {
        $rideId = DB::table('rides')->insertGetId([
            'passenger_id' => $this->passengerId,
            'pickup_lat' => -6.1622,
            'pickup_lng' => 35.7516,
            'dest_lat' => -6.1722,
            'dest_lng' => 35.7616,
            'pickup_address' => 'Train Station',
            'destination_address' => 'University',
            'fare' => 4000,
            'status' => 'requested',
            'ride_token' => Str::uuid(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs(\App\Models\User::find($this->passengerId));

        $cancelResponse = $this->post(route('rides.cancel', $rideId));
        $cancelResponse->assertStatus(302);

        $this->assertDatabaseHas('rides', [
            'id' => $rideId,
            'status' => 'cancelled',
        ]);
    }

    public function test_ride_show_page_contains_live_tracking_elements()
    {
        $rideId = DB::table('rides')->insertGetId([
            'passenger_id' => $this->passengerId,
            'rider_id' => $this->riderId,
            'pickup_lat' => -6.1622,
            'pickup_lng' => 35.7516,
            'dest_lat' => -6.1722,
            'dest_lng' => 35.7616,
            'pickup_address' => 'City Center',
            'destination_address' => 'Airport',
            'fare' => 8000,
            'status' => 'ongoing',
            'ride_token' => Str::uuid(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->get("/rides/{$rideId}");
        $response->assertStatus(200);
        $response->assertSee('live-map', false);
        $response->assertSee('mqtt');
        $response->assertSee('statusTopic');
    }
}
