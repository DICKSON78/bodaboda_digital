<?php

namespace App\Events;

use App\Models\Ride;
use App\Models\Rider;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RideAccepted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The ride instance.
     */
    public Ride $ride;

    /**
     * The rider who accepted the ride.
     */
    public array $rider;

    /**
     * Create a new event instance.
     */
    public function __construct(Ride $ride, array $rider)
    {
        $this->ride = $ride;
        $this->rider = $rider;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('ride.' . $this->ride->id),
            new PrivateChannel('user.' . $this->ride->passenger_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'ride.accepted';
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
            'status' => $this->ride->status,
            'rider' => $this->rider,
            'accepted_at' => $this->ride->accepted_at?->toIso8601String(),
            'timestamp' => now()->toIso8601String(),
        ];
    }
}
