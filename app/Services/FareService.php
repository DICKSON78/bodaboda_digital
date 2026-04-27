<?php

namespace App\Services;

class FareService
{
    protected $baseFare = 1000; // Example base fare in TZS
    protected $ratePerKm = 500;  // Example rate per km in TZS

    /**
     * Calculate fare based on distance in kilometers.
     */
    public function calculate($distance)
    {
        return $this->baseFare + ($distance * $this->ratePerKm);
    }
}
