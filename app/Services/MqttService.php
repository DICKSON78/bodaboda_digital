<?php

namespace App\Services;

use App\Jobs\PublishToMqtt;
use App\Models\Ride;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use Illuminate\Support\Facades\Log;

class MqttService
{
    protected MqttClient $client;
    protected bool $connected = false;

    public function __construct()
    {
        $host = config('mqtt.host', 'mosquitto');
        $port = config('mqtt.port', 1883);
        $clientId = config('mqtt.client_id', 'bodaboda-backend-' . uniqid());

        $this->client = new MqttClient($host, $port, $clientId);
    }

    public function rideStatusTopic(Ride $ride): string
    {
        return config('mqtt.topics.ride_status') . '/' . $ride->id . '/' . $ride->ride_token;
    }

    public function driverLocationTopic(Ride $ride): string
    {
        return config('mqtt.topics.driver_location') . '/' . $ride->rider_id . '/' . $ride->ride_token;
    }

    public function driverLocationRawTopic(int $riderId): string
    {
        return config('mqtt.topics.driver_location') . '/' . $riderId;
    }

    public function connect(): void
    {
        if ($this->connected) {
            return;
        }

        try {
            $settings = (new ConnectionSettings)
                ->setUsername(config('mqtt.username', ''))
                ->setPassword(config('mqtt.password', ''))
                ->setUseTls(config('mqtt.use_tls', false))
                ->setKeepAliveInterval(60);

            $this->client->connect($settings, true);
            $this->connected = true;

            Log::info('MQTT connected successfully', [
                'host' => config('mqtt.host'),
                'port' => config('mqtt.port'),
            ]);
        } catch (\Exception $e) {
            Log::error('MQTT connection failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function publish(string $topic, array $data, int $qos = null, bool $retain = null): void
    {
        $qos = $qos ?? config('mqtt.qos', 1);
        $retain = $retain ?? config('mqtt.retain', false);

        try {
            $this->connect();
            $payload = json_encode(array_merge($data, [
                'timestamp' => now()->toIso8601String(),
            ]));

            $this->client->publish($topic, $payload, $qos, $retain);

            Log::info('MQTT published', ['topic' => $topic, 'payload' => $payload]);
        } catch (\Exception $e) {
            Log::error('MQTT publish failed: ' . $e->getMessage(), [
                'topic' => $topic,
                'data' => $data,
            ]);
        }
    }

    public function subscribe(string $topic, callable $callback, int $qos = null): void
    {
        $qos = $qos ?? config('mqtt.qos', 1);

        try {
            $this->connect();
            $this->client->subscribe($topic, function (string $topic, string $message) use ($callback) {
                $data = json_decode($message, true);
                Log::info('MQTT received', ['topic' => $topic, 'message' => $data]);
                $callback($topic, $data);
            }, $qos);

            $this->client->loop(true);
        } catch (\Exception $e) {
            Log::error('MQTT subscribe failed: ' . $e->getMessage(), [
                'topic' => $topic,
            ]);
        }
    }

    public function queuePublish(string $topic, array $data, ?int $qos = null, ?bool $retain = null): void
    {
        PublishToMqtt::dispatch($topic, $data, $qos, $retain);
    }

    public function disconnect(): void
    {
        if ($this->connected) {
            try {
                $this->client->disconnect();
                $this->connected = false;
                Log::info('MQTT disconnected');
            } catch (\Exception $e) {
                Log::error('MQTT disconnect failed: ' . $e->getMessage());
            }
        }
    }

    public function __destruct()
    {
        if ($this->connected) {
            try {
                $this->client->disconnect();
            } catch (\Exception $e) {
                // Silently handle disconnect errors during shutdown
            }
            $this->connected = false;
        }
    }
}
