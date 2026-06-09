<?php

require __DIR__ . '/../vendor/autoload.php';

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

/**
 * Passenger Simulator for MQTT Ride Request Demo
 *
 * Usage:
 *   php scripts/passenger_simulator.php [host] [port] [username] [password]
 *
 * Defaults:
 *   host:     127.0.0.1
 *   port:     1883
 *   username: (anonymous)
 *   password: (none)
 *
 * Example with auth:
 *   php scripts/passenger_simulator.php localhost 1883 your_username your_password
 */

$host = $argv[1] ?? '127.0.0.1';
$port = (int)($argv[2] ?? 1883);
$mqttUser = $argv[3] ?? null;
$mqttPass = $argv[4] ?? null;
$passengerName = 'Jane Passenger';
$passengerId = 'passenger-' . substr(uniqid(), -6);

echo " Passenger Simulator\n";
echo " Broker: {$host}:{$port}\n";
echo " Passenger: {$passengerName} (ID: {$passengerId})\n";
echo "----------------------------------------\n";

$client = new MqttClient($host, $port, $passengerId);

$settings = (new ConnectionSettings)->setKeepAliveInterval(60);
if ($mqttUser) {
    $settings->setUsername($mqttUser)->setPassword($mqttPass);
}

$client->connect($settings, true);
echo " Connected to MQTT broker\n";

// Subscribe to ride status updates (wildcard for all rides)
$client->subscribe('ride/status/#', function (string $topic, string $message) {
    $data = json_decode($message, true);
    if (!$data) return;

    $status = $data['status'] ?? 'unknown';
    $statusLabels = [
        'accepted' => " ACCEPTED - Driver is on the way!",
        'driver_arriving' => " DRIVER ARRIVING - Look out!",
        'driver_arrived' => " DRIVER ARRIVED - Get in!",
        'ongoing' => " TRIP STARTED - En route to destination",
        'completed' => " COMPLETED - Arrived safely!",
        'cancelled' => " CANCELLED - Ride was cancelled",
    ];

    $emoji = $statusLabels[$status] ?? " {$status}";
    echo "\n RIDE STATUS UPDATE: {$emoji}\n";
    echo " Topic: {$topic}\n";
    echo " Ride #: {$data['ride_id']}\n";

    if (isset($data['driver']['name'])) {
        echo " Driver: {$data['driver']['name']} ({$data['driver']['bike_plate']})\n";
    }
    if (isset($data['fare'])) {
        echo " Fare: TZS " . number_format($data['fare']) . "\n";
    }
}, MqttClient::QOS_AT_LEAST_ONCE);

// Send a ride request
echo "\n Sending ride request...\n";

$rideId = rand(100, 999);
$payload = json_encode([
    'ride_id' => $rideId,
    'passenger_id' => $passengerId,
    'pickup' => [
        'lat' => -6.7924,
        'lng' => 39.2083,
        'address' => 'Nyerere Square, Dar es Salaam',
    ],
    'destination' => [
        'lat' => -6.8222,
        'lng' => 39.2695,
        'address' => 'Kariakoo Market, Dar es Salaam',
    ],
    'fare' => 5000,
    'distance' => 4.5,
    'timestamp' => date('c'),
]);

$client->publish('ride/request', $payload, MqttClient::QOS_AT_LEAST_ONCE);
echo " Published: ride/request → Ride #{$rideId}\n";
echo "\n Waiting for driver responses... (Ctrl+C to stop)\n";

$client->loop(true);
