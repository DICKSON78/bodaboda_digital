<?php

namespace App\Jobs;

use App\Services\MqttService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PublishToMqtt implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The MQTT topic to publish to.
     */
    public string $topic;

    /**
     * The data payload to publish.
     */
    public array $data;

    /**
     * The QoS level.
     */
    public ?int $qos;

    /**
     * Whether to retain the message.
     */
    public ?bool $retain;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(string $topic, array $data, ?int $qos = null, ?bool $retain = null)
    {
        $this->topic = $topic;
        $this->data = $data;
        $this->qos = $qos;
        $this->retain = $retain;
    }

    /**
     * Execute the job.
     */
    public function handle(MqttService $mqtt): void
    {
        $mqtt->publish($this->topic, $this->data, $this->qos, $this->retain);
    }
}
