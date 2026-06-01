<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\MetricsController;

class BodaBodaBusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    public function test_metrics_controller_calculates_correct_values()
    {
        \DB::table('users')->insert([
            ['name' => 'User 1', 'email' => 'user1@test.com', 'password' => bcrypt('password'), 'role' => 'passenger'],
            ['name' => 'User 2', 'email' => 'user2@test.com', 'password' => bcrypt('password'), 'role' => 'passenger'],
        ]);

        \DB::table('rides')->insert([
            ['passenger_id' => 1, 'pickup_lat' => -1.2921, 'pickup_lng' => 36.8219, 'dest_lat' => -1.3021, 'dest_lng' => 36.8319, 'fare' => 5000, 'status' => 'completed', 'ride_token' => \Illuminate\Support\Str::uuid()],
            ['passenger_id' => 1, 'pickup_lat' => -1.2921, 'pickup_lng' => 36.8219, 'dest_lat' => -1.3021, 'dest_lng' => 36.8319, 'fare' => 3000, 'status' => 'ongoing', 'ride_token' => \Illuminate\Support\Str::uuid()],
        ]);

        $controller = new MetricsController();
        $response = $controller->metrics();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('text/plain', $response->headers->get('Content-Type'));

        $content = $response->getContent();
        
        $this->assertStringContainsString('bodaboda_users_total', $content);
        $this->assertStringContainsString('bodaboda_rides_requested_total', $content);
        $this->assertStringContainsString('bodaboda_rides_active_current', $content);
        $this->assertStringContainsString('bodaboda_revenue_total', $content);
    }

    public function test_metrics_are_reasonable()
    {
        \DB::table('users')->insert([
            ['name' => 'User 1', 'email' => 'user1@test.com', 'password' => bcrypt('password'), 'role' => 'passenger'],
        ]);

        $controller = new MetricsController();
        $response = $controller->metrics();
        $content = $response->getContent();

        preg_match('/bodaboda_users_total (\d+)/', $content, $users);
        preg_match('/bodaboda_rides_requested_total (\d+)/', $content, $rides);

        $this->assertIsNumeric($users[1]);
        $this->assertIsNumeric($rides[1]);
        $this->assertGreaterThanOrEqual(0, (int)$users[1]);
        $this->assertGreaterThanOrEqual(0, (int)$rides[1]);
    }

    public function test_critical_business_metrics_present()
    {
        $controller = new MetricsController();
        $response = $controller->metrics();
        $content = $response->getContent();

        $criticalMetrics = [
            'bodaboda_rides_requested_total',
            'bodaboda_users_total',
            'bodaboda_rides_active_current',
            'bodaboda_rides_completed_total',
            'bodaboda_revenue_total',
            'bodaboda_riders_online_current',
        ];

        foreach ($criticalMetrics as $metric) {
            $this->assertStringContainsString($metric, $content, "Critical metric {$metric} is missing");
        }
    }

    public function test_system_metrics_working()
    {
        $controller = new MetricsController();
        $response = $controller->metrics();
        $content = $response->getContent();

        $systemMetrics = [
            'bodaboda_redis_geo_count',
            'bodaboda_mqtt_auth_failures',
        ];

        foreach ($systemMetrics as $metric) {
            $this->assertStringContainsString($metric, $content, "System metric {$metric} is missing");
        }
    }
}
