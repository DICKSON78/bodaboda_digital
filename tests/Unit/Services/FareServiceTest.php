<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\FareService;

class FareServiceTest extends TestCase
{
    protected FareService $fareService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fareService = app(FareService::class);
    }

    public function test_calculate_fare_for_basic_distance()
    {
        $fare = $this->fareService->calculate(5, -6.17, 35.74);
        $this->assertIsNumeric($fare);
        $this->assertGreaterThan(0, $fare);
    }

    public function test_minimum_fare_applies_for_short_distance()
    {
        $fare = $this->fareService->calculate(0.5);
        $this->assertIsNumeric($fare);
        $this->assertGreaterThanOrEqual(1000, $fare);
    }

    public function test_calculate_fare_returns_even_hundreds()
    {
        $fare = $this->fareService->calculate(10);
        $this->assertEquals(0, $fare % 100);
    }

    public function test_get_current_surge_returns_multiplier()
    {
        $surge = $this->fareService->getCurrentSurge();
        $this->assertIsFloat($surge);
        $this->assertGreaterThanOrEqual(1.0, $surge);
    }

    public function test_get_active_zones()
    {
        $zones = $this->fareService->getActiveZones();
        $this->assertContains('default', $zones);
        $this->assertContains('central', $zones);
        $this->assertContains('airport', $zones);
    }
}
