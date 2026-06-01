<?php

namespace App\Events;

use App\Models\Ride;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RideRequested implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The ride instance.
     */
    public Ride $ride;

    /**
     * The passenger who requested the ride.
     */
    public array $passenger;

    /**
     * Pickup coordinates.
     */
    public array $pickup;

    /**
     * Destination coordinates.
     */
    public array $destination;

    /**
     * The calculated fare.
     */
    public float $fare;

    /**
     * The distance in kilometers.
     */
    public float $distance;

    /**
     * Create a new event instance.
     */
    public function __construct(Ride $ride, array $passenger, array $pickup, array $destination, float $fare, float $distance)
    {
        $this->ride = $ride;
        $this->passenger = $passenger;
        $this->pickup = $pickup;
        $this->destination = $destination;
        $this->fare = $fare;
        $this->distance = $distance;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('rides'),
            new PrivateChannel('ride.' . $this->ride->id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'ride.requested';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'ride_id' => $this->ride->id,
            'passenger' => $this->passenger,
            'pickup' => $this->pickup,
            'destination' => $this->destination,
            'fare' => $this->fare,
            'distance' => $this->distance,
            'status' => $this->ride->status,
            'timestamp' => now()->toIso8601String(),
        ];
    }
}
