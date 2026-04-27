<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rider extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone_number',
        'license_number',
        'bike_plate',
        'bike_image',
        'status',
        'is_approved',
        'current_lat',
        'current_lng',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rides()
    {
        return $this->hasMany(Ride::class);
    }
}
