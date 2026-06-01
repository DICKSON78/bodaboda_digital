<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class GeoService
{
    protected string $onlineKey = 'riders:online';
    protected string $statusKey = 'rider:status';

    public function setLocation(int $riderId, float $lat, float $lng): void
    {
        Redis::geoadd($this->onlineKey, $lng, $lat, (string) $riderId);
    }

    public function removeLocation(int $riderId): void
    {
        Redis::zrem($this->onlineKey, (string) $riderId);
    }

    public function findNearby(float $lat, float $lng, float $radiusKm = 5, int $limit = 20): array
    {
        $results = Redis::georadius(
            $this->onlineKey,
            $lng,
            $lat,
            $radiusKm,
            'km',
            'WITHDIST',
            'WITHCOORD',
            'COUNT',
            $limit,
            'ASC'
        );

        if (!$results) return [];

        $ids = collect($results)->pluck(0)->map(fn($id) => (int) $id)->toArray();
        if (empty($ids)) return [];

        $riders = \App\Models\Rider::whereIn('id', $ids)
            ->where('status', 'online')
            ->where('is_approved', true)
            ->with('user:id,name,avatar,phone_number')
            ->get()
            ->keyBy('id');

        $nearby = [];
        foreach ($results as $result) {
            $riderId = (int) $result[0];
            $rider = $riders->get($riderId);
            if (!$rider) continue;

            $nearby[] = $rider;
        }

        return $nearby;
    }

    public function getLocation(int $riderId): ?array
    {
        $pos = Redis::geopos($this->onlineKey, (string) $riderId);
        if (!$pos || !$pos[0]) return null;

        return [
            'lat' => (float) $pos[0][1],
            'lng' => (float) $pos[0][0],
        ];
    }

    public function isOnline(int $riderId): bool
    {
        return Redis::zrank($this->onlineKey, (string) $riderId) !== null;
    }

    public function clearAll(): void
    {
        Redis::del($this->onlineKey);
    }
}
