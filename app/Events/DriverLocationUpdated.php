<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DriverLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The rider (driver) ID.
     */
    public int $riderId;

    /**
     * The latitude coordinate.
     */
    public float $lat;

    /**
     * The longitude coordinate.
     */
    public float $lng;

    /**
     * The heading/direction in degrees (optional).
     */
    public ?float $heading;

    /**
     * The current speed in km/h (optional).
     */
    public ?float $speed;

    /**
     * Create a new event instance.
     */
    public function __construct(int $riderId, float $lat, float $lng, ?float $heading = null, ?float $speed = null)
    {
        $this->riderId = $riderId;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->heading = $heading;
        $this->speed = $speed;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('driver-locations'),
            new PrivateChannel('rider.' . $this->riderId),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'driver.location.updated';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'rider_id' => $this->riderId,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'heading' => $this->heading,
            'speed' => $this->speed,
            'timestamp' => now()->toIso8601String(),
        ];
    }
}
