<?php

namespace App\Services;

class FareService
{
    protected array $baseRates = [
        'default' => ['base' => 1000, 'per_km' => 500],
        'central' => ['base' => 1500, 'per_km' => 600],
        'airport' => ['base' => 3000, 'per_km' => 800],
        'suburb' => ['base' => 2000, 'per_km' => 700],
    ];

    protected array $surgeHours = [
        // Morning peak 6-9am: 1.5x
        ['start' => 6, 'end' => 9, 'multiplier' => 1.5],
        // Evening peak 5-8pm: 1.8x
        ['start' => 17, 'end' => 20, 'multiplier' => 1.8],
        // Late night 11pm-5am: 2.0x
        ['start' => 23, 'end' => 5, 'multiplier' => 2.0],
    ];

    protected array $zoneCenters = [
        'central' => ['lat' => -6.1731, 'lng' => 35.7419, 'radius_km' => 3],
        'airport' => ['lat' => -6.1689, 'lng' => 35.7520, 'radius_km' => 2],
    ];

    public function calculate($distance, ?float $pickupLat = null, ?float $pickupLng = null): float
    {
        $zone = $this->resolveZone($pickupLat, $pickupLng);
        $rate = $this->baseRates[$zone] ?? $this->baseRates['default'];
        $surge = $this->getSurgeMultiplier();

        $fare = ($rate['base'] + ($distance * $rate['per_km'])) * $surge;

        return round(max($fare, $rate['base']), -2);
    }

    protected function resolveZone(?float $lat, ?float $lng): string
    {
        if ($lat === null || $lng === null) return 'default';

        foreach ($this->zoneCenters as $zone => $center) {
            $dist = $this->haversine($lat, $lng, $center['lat'], $center['lng']);
            if ($dist <= $center['radius_km']) {
                return $zone;
            }
        }

        return 'default';
    }

    protected function getSurgeMultiplier(): float
    {
        $hour = (int) now()->format('G');

        foreach ($this->surgeHours as $period) {
            if ($period['start'] <= $period['end']) {
                if ($hour >= $period['start'] && $hour < $period['end']) {
                    return $period['multiplier'];
                }
            } else {
                // Overnight period (e.g., 23:00 - 05:00)
                if ($hour >= $period['start'] || $hour < $period['end']) {
                    return $period['multiplier'];
                }
            }
        }

        return 1.0;
    }

    private function haversine($lat1, $lng1, $lat2, $lng2): float
    {
        $R = 6371;
        $dLat = ($lat2 - $lat1) * M_PI / 180;
        $dLng = ($lng2 - $lng1) * M_PI / 180;
        $a = sin($dLat/2) * sin($dLat/2) +
             cos($lat1 * M_PI / 180) * cos($lat2 * M_PI / 180) *
             sin($dLng/2) * sin($dLng/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $R * $c;
    }

    public function getCurrentSurge(): float
    {
        return $this->getSurgeMultiplier();
    }

    public function getActiveZones(): array
    {
        return array_keys($this->baseRates);
    }
}
