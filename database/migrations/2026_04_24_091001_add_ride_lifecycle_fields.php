<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rides', function (Blueprint $table) {
            // Add driver_id if not exists
            if (!Schema::hasColumn('rides', 'driver_id')) {
                $table->foreignId('driver_id')->nullable()->constrained('riders')->onDelete('set null');
            }
            
            // Add timestamps for status tracking if not exists
            if (!Schema::hasColumn('rides', 'accepted_at')) {
                $table->timestamp('accepted_at')->nullable();
            }
            if (!Schema::hasColumn('rides', 'driver_arrived_at')) {
                $table->timestamp('driver_arrived_at')->nullable();
            }
            if (!Schema::hasColumn('rides', 'trip_started_at')) {
                $table->timestamp('trip_started_at')->nullable();
            }
            if (!Schema::hasColumn('rides', 'trip_completed_at')) {
                $table->timestamp('trip_completed_at')->nullable();
            }
            
            // Add pickup and destination addresses if not exists
            if (!Schema::hasColumn('rides', 'pickup_address')) {
                $table->string('pickup_address')->nullable();
            }
            if (!Schema::hasColumn('rides', 'destination_address')) {
                $table->string('destination_address')->nullable();
            }
            
            // Add indexing for performance
            $table->index(['status', 'created_at']);
            $table->index(['driver_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
