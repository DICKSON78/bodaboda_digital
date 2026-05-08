<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    /**
     * Health check endpoint for CI/CD
     */
    public function health()
    {
        try {
            // Check database connection
            DB::connection()->getPdo();
            
            return response()->json([
                'status' => 'healthy',
                'service' => 'BodaBoda Digital',
                'version' => '1.0.0',
                'timestamp' => now()->toISOString(),
                'database' => 'connected',
                'environment' => app()->environment()
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'unhealthy',
                'service' => 'BodaBoda Digital',
                'error' => $e->getMessage(),
                'timestamp' => now()->toISOString()
            ], 503);
        }
    }
}
