<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class MetricsController extends Controller
{
    public function metrics()
    {
        $metrics = [];

        $metrics[] = '# HELP bodaboda_rides_requested_total Total rides requested';
        $metrics[] = '# TYPE bodaboda_rides_requested_total counter';
        $metrics[] = 'bodaboda_rides_requested_total ' . $this->safeCount('rides');

        $metrics[] = '# HELP bodaboda_rides_active_current Rides in progress (accepted/ongoing)';
        $metrics[] = '# TYPE bodaboda_rides_active_current gauge';
        $metrics[] = 'bodaboda_rides_active_current ' . $this->safeCount('rides', 'status', ['accepted', 'ongoing']);

        $metrics[] = '# HELP bodaboda_rides_completed_total Total completed rides';
        $metrics[] = '# TYPE bodaboda_rides_completed_total counter';
        $metrics[] = 'bodaboda_rides_completed_total ' . $this->safeCount('rides', 'status', 'completed');

        $metrics[] = '# HELP bodaboda_riders_online_current Online riders';
        $metrics[] = '# TYPE bodaboda_riders_online_current gauge';
        $metrics[] = 'bodaboda_riders_online_current ' . $this->safeCount('riders', 'status', 'online');

        $metrics[] = '# HELP bodaboda_revenue_total Total revenue in TZS';
        $metrics[] = '# TYPE bodaboda_revenue_total counter';
        $metrics[] = 'bodaboda_revenue_total ' . $this->safeSum('rides', 'fare', 'status', 'completed');

        $metrics[] = '# HELP bodaboda_users_total Total registered users';
        $metrics[] = '# TYPE bodaboda_users_total counter';
        $metrics[] = 'bodaboda_users_total ' . $this->safeCount('users');

        $metrics[] = '# HELP bodaboda_mqtt_auth_failures MQTT authentication failures';
        $metrics[] = '# TYPE bodaboda_mqtt_auth_failures counter';
        $metrics[] = 'bodaboda_mqtt_auth_failures ' . Cache::get('mqtt_auth_failures', 0);

        $metrics[] = '# HELP bodaboda_redis_geo_count Riders in Redis geo-index';
        $metrics[] = '# TYPE bodaboda_redis_geo_count gauge';
        try {
            $geoCount = \Illuminate\Support\Facades\Redis::zcard('riders:online');
        } catch (\Exception $e) {
            $geoCount = 0;
        }
        $metrics[] = 'bodaboda_redis_geo_count ' . $geoCount;

        return response(implode("\n", $metrics), 200)
            ->header('Content-Type', 'text/plain');
    }

    private function safeCount(string $table, string $column = null, $value = null): int
    {
        try {
            if (!Schema::hasTable($table)) return 0;
            $query = DB::table($table);
            if ($column) {
                if (is_array($value)) {
                    $query->whereIn($column, $value);
                } else {
                    $query->where($column, $value);
                }
            }
            return (int) $query->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function safeSum(string $table, string $column, string $whereColumn = null, string $whereValue = null): float
    {
        try {
            if (!Schema::hasTable($table)) return 0;
            $query = DB::table($table);
            if ($whereColumn) {
                $query->where($whereColumn, $whereValue);
            }
            return (float) ($query->sum($column) ?? 0);
        } catch (\Exception $e) {
            return 0;
        }
    }
}
