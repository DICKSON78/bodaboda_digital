<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Rider;
use App\Models\User;
use App\Services\GeoService;
use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GeoServiceTest extends TestCase
{
    use RefreshDatabase;

    protected GeoService $geo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->geo = app(GeoService::class);
        Redis::del('riders:online');
    }

    public function test_set_location_adds_to_geo_index()
    {
        $this->geo->setLocation(1, -6.17, 35.74);
        $this->geo->setLocation(2, -6.18, 35.75);

        $pos = Redis::geopos('riders:online', '1');
        $this->assertNotNull($pos);
        $this->assertEquals(35.74, round($pos[0][0], 2));
    }

    public function test_find_nearby_returns_riders_within_radius()
    {
        $user = User::factory()->create();
        $rider1 = Rider::factory()->create([
            'user_id' => $user->id,
            'status' => 'online',
            'is_approved' => true,
        ]);
        $rider2 = Rider::factory()->create([
            'user_id' => User::factory()->create()->id,
            'status' => 'online',
            'is_approved' => true,
        ]);

        $this->geo->setLocation($rider1->id, -6.17, 35.74);
        $this->geo->setLocation($rider2->id, -6.20, 35.78);

        $nearby = $this->geo->findNearby(-6.17, 35.74, 10, 20);
        $this->assertCount(2, $nearby);
    }

    public function test_remove_location_removes_from_index()
    {
        $this->geo->setLocation(1, -6.17, 35.74);
        $this->geo->removeLocation(1);
        $this->assertFalse($this->geo->isOnline(1));
    }

    public function test_get_location_returns_coordinates()
    {
        $this->geo->setLocation(1, -6.1731, 35.7419);
        $loc = $this->geo->getLocation(1);
        $this->assertNotNull($loc);
        $this->assertEquals(-6.1731, round($loc['lat'], 4));
        $this->assertEquals(35.7419, round($loc['lng'], 4));
    }

    public function test_is_online_returns_correct_status()
    {
        $this->assertFalse($this->geo->isOnline(999));
        $this->geo->setLocation(5, -6.17, 35.74);
        $this->assertTrue($this->geo->isOnline(5));
    }
}
