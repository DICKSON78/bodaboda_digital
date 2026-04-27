<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ride extends Model
{
    use HasFactory;

    protected $fillable = [
        'passenger_id',
        'rider_id',
        'pickup_lat',
        'pickup_lng',
        'dest_lat',
        'dest_lng',
        'fare',
        'status',
    ];

    public function passenger()
    {
        return $this->belongsTo(User::class, 'passenger_id');
    }

    public function rider()
    {
        return $this->belongsTo(Rider::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
