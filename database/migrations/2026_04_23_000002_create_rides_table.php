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
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('passenger_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('rider_id')->nullable()->constrained('riders')->onDelete('set null');
            $table->decimal('pickup_lat', 10, 8);
            $table->decimal('pickup_lng', 11, 8);
            $table->decimal('dest_lat', 10, 8);
            $table->decimal('dest_lng', 11, 8);
            $table->decimal('fare', 10, 2);
            $table->enum('status', ['requested', 'accepted', 'ongoing', 'completed', 'cancelled'])->default('requested');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
