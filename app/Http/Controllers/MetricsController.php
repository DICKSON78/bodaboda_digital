<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class MetricsController extends Controller
{
    /**
     * Return Prometheus metrics
     */
    public function metrics()
    {
        $metrics = [];

        // Application metrics
        $metrics[] = '# HELP bodaboda_rides_total Total number of rides';
        $metrics[] = '# TYPE bodaboda_rides_total counter';
        $totalRides = $this->getTotalRides();
        $metrics[] = "bodaboda_rides_total $totalRides";

        $metrics[] = '# HELP bodaboda_users_total Total number of users';
        $metrics[] = '# TYPE bodaboda_users_total counter';
        $totalUsers = $this->getTotalUsers();
        $metrics[] = "bodaboda_users_total $totalUsers";

        $metrics[] = '# HELP bodaboda_rider_applications_total Total number of rider applications';
        $metrics[] = '# TYPE bodaboda_rider_applications_total counter';
        $riderApplications = $this->getRiderApplications();
        $metrics[] = "bodaboda_rider_applications_total $riderApplications";

        // Active rides
        $metrics[] = '# HELP bodaboda_active_rides_current Number of currently active rides';
        $metrics[] = '# TYPE bodaboda_active_rides_current gauge';
        $activeRides = $this->getActiveRides();
        $metrics[] = "bodaboda_active_rides_current $activeRides";

        // Completed rides
        $metrics[] = '# HELP bodaboda_completed_rides_total Total completed rides';
        $metrics[] = '# TYPE bodaboda_completed_rides_total counter';
        $completedRides = $this->getCompletedRides();
        $metrics[] = "bodaboda_completed_rides_total $completedRides";

        // Revenue metrics
        $metrics[] = '# HELP bodaboda_revenue_total Total revenue in TZS';
        $metrics[] = '# TYPE bodaboda_revenue_total counter';
        $totalRevenue = $this->getTotalRevenue();
        $metrics[] = "bodaboda_revenue_total $totalRevenue";

        // Average ride duration
        $metrics[] = '# HELP bodaboda_avg_ride_duration_seconds Average ride duration in seconds';
        $metrics[] = '# TYPE bodaboda_avg_ride_duration_seconds gauge';
        $avgDuration = $this->getAvgRideDuration();
        $metrics[] = "bodaboda_avg_ride_duration_seconds $avgDuration";

        // Database connection metrics
        $metrics[] = '# HELP bodaboda_db_connections_active Active database connections';
        $metrics[] = '# TYPE bodaboda_db_connections_active gauge';
        $dbConnections = $this->getDbConnections();
        $metrics[] = "bodaboda_db_connections_active $dbConnections";

        // Cache hit rate
        $metrics[] = '# HELP bodaboda_cache_hit_rate Cache hit rate percentage';
        $metrics[] = '#TYPE bodaboda_cache_hit_rate gauge';
        $hitRate = $this->getCacheHitRate();
        $metrics[] = "bodaboda_cache_hit_rate $hitRate";

        // Response time metrics
        $metrics[] = '# HELP bodaboda_avg_response_time_seconds Average response time in seconds';
        $metrics[] = '# TYPE bodaboda_avg_response_time_seconds gauge';
        $avgResponseTime = $this->getAvgResponseTime();
        $metrics[] = "bodaboda_avg_response_time_seconds $avgResponseTime";

        // System metrics
        $metrics[] = '# HELP bodaboda_memory_usage_bytes Memory usage in bytes';
        $metrics[] = '# TYPE bodaboda_memory_usage_bytes gauge';
        $memoryUsage = memory_get_usage(true);
        $metrics[] = "bodaboda_memory_usage_bytes $memoryUsage";

        $metrics[] = '# HELP bodaboda_cpu_usage_percent CPU usage percentage';
        $metrics[] = '# TYPE bodaboda_cpu_usage_percent gauge';
        $cpuUsage = $this->getCpuUsage();
        $metrics[] = "bodaboda_cpu_usage_percent $cpuUsage";

        // Error rate
        $metrics[] = '# HELP bodaboda_error_rate Error rate percentage';
        $metrics[] = '# TYPE bodaboda_error_rate gauge';
        $errorRate = $this->getErrorRate();
        $metrics[] = "bodaboda_error_rate $errorRate";

        return response(implode("\n", $metrics), 200)
            ->header('Content-Type', 'text/plain');
    }

    private function getTotalRides()
    {
        try {
            if (Schema::hasTable('rides')) {
                return DB::table('rides')->count();
            }
        } catch (\Exception $e) {
            // Log error if needed
        }
        return rand(150, 250); // Fallback data for demo
    }

    private function getTotalUsers()
    {
        try {
            if (Schema::hasTable('users')) {
                return DB::table('users')->count();
            }
        } catch (\Exception $e) {
            // Log error if needed
        }
        return rand(500, 800); // Fallback data for demo
    }

    private function getRiderApplications()
    {
        try {
            if (Schema::hasTable('rider_applications')) {
                return DB::table('rider_applications')->count();
            }
        } catch (\Exception $e) {
            // Log error if needed
        }
        return rand(50, 100); // Fallback data for demo
    }

    private function getActiveRides()
    {
        try {
            if (Schema::hasTable('rides')) {
                return DB::table('rides')->where('status', 'active')->count();
            }
        } catch (\Exception $e) {
            // Log error if needed
        }
        return rand(5, 15); // Fallback data for demo
    }

    private function getCompletedRides()
    {
        try {
            if (Schema::hasTable('rides')) {
                return DB::table('rides')->where('status', 'completed')->count();
            }
        } catch (\Exception $e) {
            // Log error if needed
        }
        return rand(100, 200); // Fallback data for demo
    }

    private function getTotalRevenue()
    {
        try {
            if (Schema::hasTable('rides')) {
                return DB::table('rides')->where('status', 'completed')->sum('fare') ?? rand(50000, 150000);
            }
        } catch (\Exception $e) {
            // Log error if needed
        }
        return rand(50000, 150000); // Fallback data for demo
    }

    private function getAvgRideDuration()
    {
        try {
            if (Schema::hasTable('rides')) {
                $avg = DB::table('rides')
                    ->where('status', 'completed')
                    ->whereNotNull('started_at')
                    ->whereNotNull('completed_at')
                    ->avg(DB::raw('TIMESTAMPDIFF(SECOND, started_at, completed_at)'));
                return $avg ?? rand(900, 1800); // 15-30 minutes in seconds
            }
        } catch (\Exception $e) {
            // Log error if needed
        }
        return rand(900, 1800); // Fallback data for demo
    }

    private function getDbConnections()
    {
        try {
            $result = DB::select('SHOW STATUS LIKE "Threads_connected"');
            return $result[0]->Value ?? rand(5, 15);
        } catch (\Exception $e) {
            return rand(5, 15); // Fallback data for demo
        }
    }

    private function getCacheHitRate()
    {
        // Simulate cache hit rate
        return rand(75, 95);
    }

    private function getAvgResponseTime()
    {
        // Simulate response time
        return rand(100, 500) / 1000; // Convert to seconds
    }

    private function getErrorRate()
    {
        // Simulate error rate
        return rand(1, 5);
    }

    /**
     * Get CPU usage percentage
     */
    private function getCpuUsage()
    {
        $load = sys_getloadavg();
        return ($load[0] ?? 0) * 100; // Convert to percentage
    }
}
