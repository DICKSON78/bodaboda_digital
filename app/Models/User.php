<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'google_id', 'avatar', 'role', 'suspended_at'])]
#[Hidden(['password', 'remember_token', 'google_id'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rider()
    {
        return $this->hasOne(Rider::class);
    }

    public function ridesAsPassenger()
    {
        return $this->hasMany(Ride::class, 'passenger_id');
    }

    public function ratingsReceived()
    {
        return $this->hasMany(Rating::class, 'to_user_id');
    }

    public function ratingsGiven()
    {
        return $this->hasMany(Rating::class, 'from_user_id');
    }

    public function isRider()
    {
        return $this->role === 'rider';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
