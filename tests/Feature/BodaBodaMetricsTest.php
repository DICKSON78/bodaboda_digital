<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BodaBodaMetricsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test metrics endpoint returns valid Prometheus format
     */
    public function test_metrics_endpoint_returns_prometheus_format()
    {
        // Create test data
        $userId = DB::table('users')->insertGetId([
            'name' => 'Test User', 'email' => 'test@example.com', 'password' => bcrypt('password'), 'role' => 'passenger'
        ]);

        DB::table('users')->insert([
            ['name' => 'Test User 2', 'email' => 'test2@example.com', 'password' => bcrypt('password'), 'role' => 'passenger'],
        ]);

        DB::table('rides')->insert([
            ['passenger_id' => $userId, 'pickup_lat' => -1.2921, 'pickup_lng' => 36.8219, 'dest_lat' => -1.3021, 'dest_lng' => 36.8319, 'fare' => 5000, 'status' => 'completed'],
            ['passenger_id' => $userId, 'pickup_lat' => -1.2921, 'pickup_lng' => 36.8219, 'dest_lat' => -1.3021, 'dest_lng' => 36.8319, 'fare' => 3000, 'status' => 'ongoing'],
        ]);

        $response = $this->get('/metrics');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');

        $content = $response->getContent();
        
        // Check for Prometheus format
        $this->assertStringContainsString('# HELP bodaboda_users_total', $content);
        $this->assertStringContainsString('# TYPE bodaboda_users_total counter', $content);
        $this->assertStringContainsString('bodaboda_users_total', $content);
        
        $this->assertStringContainsString('# HELP bodaboda_rides_total', $content);
        $this->assertStringContainsString('# TYPE bodaboda_rides_total counter', $content);
        $this->assertStringContainsString('bodaboda_rides_total', $content);
    }

    /**
     * Test metrics values are reasonable
     */
    public function test_metrics_values_are_reasonable()
    {
        $response = $this->get('/metrics');
        $content = $response->getContent();

        // Extract metric values (simple regex)
        preg_match('/bodaboda_users_total (\d+)/', $content, $users);
        preg_match('/bodaboda_rides_total (\d+)/', $content, $rides);
        preg_match('/bodaboda_memory_usage_bytes (\d+)/', $content, $memory);
        preg_match('/bodaboda_cpu_usage_percent ([\d.]+)/', $content, $cpu);

        // Validate values are reasonable
        $this->assertGreaterThanOrEqual(0, (int)$users[1]);
        $this->assertGreaterThanOrEqual(0, (int)$rides[1]);
        $this->assertGreaterThan(0, (int)$memory[1]);
        $this->assertGreaterThanOrEqual(0, (float)$cpu[1]);
        $this->assertLessThanOrEqual(100, (float)$cpu[1]);
    }

    /**
     * Test application health endpoint
     */
    public function test_health_endpoint()
    {
        $response = $this->get('/api/health');

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'healthy',
            'service' => 'BodaBoda Digital'
        ]);
    }
}
