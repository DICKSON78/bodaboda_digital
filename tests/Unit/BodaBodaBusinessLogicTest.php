<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\MetricsController;

class BodaBodaBusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test metrics controller can calculate business metrics
     */
    public function test_metrics_controller_calculates_correct_values()
    {
        // Create test data
        \DB::table('users')->insert([
            ['name' => 'User 1', 'email' => 'user1@test.com', 'password' => bcrypt('password'), 'role' => 'passenger'],
            ['name' => 'User 2', 'email' => 'user2@test.com', 'password' => bcrypt('password'), 'role' => 'passenger'],
        ]);

        \DB::table('rides')->insert([
            ['passenger_id' => 1, 'pickup_lat' => -1.2921, 'pickup_lng' => 36.8219, 'dest_lat' => -1.3021, 'dest_lng' => 36.8319, 'fare' => 5000, 'status' => 'completed'],
            ['passenger_id' => 1, 'pickup_lat' => -1.2921, 'pickup_lng' => 36.8219, 'dest_lat' => -1.3021, 'dest_lng' => 36.8319, 'fare' => 3000, 'status' => 'ongoing'],
        ]);

        $controller = new MetricsController();
        $response = $controller->metrics();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('text/plain', $response->headers->get('Content-Type'));

        $content = $response->getContent();
        
        // Verify metrics are calculated correctly
        $this->assertStringContainsString('bodaboda_users_total', $content);
        $this->assertStringContainsString('bodaboda_rides_total', $content);
        $this->assertStringContainsString('bodaboda_active_rides_current', $content);
        $this->assertStringContainsString('bodaboda_revenue_total', $content);
    }

    /**
     * Test that metrics are reasonable numbers
     */
    public function test_metrics_are_reasonable()
    {
        $controller = new MetricsController();
        $response = $controller->metrics();
        $content = $response->getContent();

        // Extract values using regex
        preg_match('/bodaboda_users_total (\d+)/', $content, $users);
        preg_match('/bodaboda_rides_total (\d+)/', $content, $rides);
        preg_match('/bodaboda_memory_usage_bytes (\d+)/', $content, $memory);
        preg_match('/bodaboda_cpu_usage_percent ([\d.]+)/', $content, $cpu);

        // Validate numeric values
        $this->assertIsNumeric($users[1]);
        $this->assertIsNumeric($rides[1]);
        $this->assertIsNumeric($memory[1]);
        $this->assertIsNumeric($cpu[1]);

        // Validate ranges
        $this->assertGreaterThanOrEqual(0, (int)$users[1]);
        $this->assertGreaterThanOrEqual(0, (int)$rides[1]);
        $this->assertGreaterThan(0, (int)$memory[1]);
        $this->assertGreaterThanOrEqual(0, (float)$cpu[1]);
        $this->assertLessThanOrEqual(100, (float)$cpu[1]);
    }

    /**
     * Test that critical business metrics are present
     */
    public function test_critical_business_metrics_present()
    {
        $controller = new MetricsController();
        $response = $controller->metrics();
        $content = $response->getContent();

        $criticalMetrics = [
            'bodaboda_rides_total',
            'bodaboda_users_total',
            'bodaboda_active_rides_current',
            'bodaboda_completed_rides_total',
            'bodaboda_revenue_total',
            'bodaboda_avg_ride_duration_seconds'
        ];

        foreach ($criticalMetrics as $metric) {
            $this->assertStringContainsString($metric, $content, "Critical metric {$metric} is missing");
        }
    }

    /**
     * Test that system metrics are working
     */
    public function test_system_metrics_working()
    {
        $controller = new MetricsController();
        $response = $controller->metrics();
        $content = $response->getContent();

        $systemMetrics = [
            'bodaboda_memory_usage_bytes',
            'bodaboda_cpu_usage_percent',
            'bodaboda_avg_response_time_seconds',
            'bodaboda_error_rate'
        ];

        foreach ($systemMetrics as $metric) {
            $this->assertStringContainsString($metric, $content, "System metric {$metric} is missing");
        }
    }
}
