<?php

require __DIR__ . '/../vendor/autoload.php';

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

/**
 * Driver Simulator for MQTT Ride Acceptance Demo
 *
 * Usage:
 *   php scripts/driver_simulator.php [host] [port] [username] [password]
 *
 * Defaults:
 *   host:     127.0.0.1
 *   port:     1883
 *   username: (anonymous)
 *   password: (none)
 *
 * Example with auth:
 *   php scripts/driver_simulator.php localhost 1883 your_username your_password
 */

$host = $argv[1] ?? '127.0.0.1';
$port = (int)($argv[2] ?? 1883);
$mqttUser = $argv[3] ?? null;
$mqttPass = $argv[4] ?? null;
$driverName = 'Juma Rider';
$driverId = 'driver-' . substr(uniqid(), -6);

echo " Driver Simulator\n";
echo " Broker: {$host}:{$port}\n";
echo " Driver: {$driverName} (ID: {$driverId})\n";
echo "----------------------------------------\n";

$client = new MqttClient($host, $port, $driverId);

$settings = (new ConnectionSettings)->setKeepAliveInterval(60);
if ($mqttUser) {
    $settings->setUsername($mqttUser)->setPassword($mqttPass);
}

$client->connect($settings, true);
echo " Connected to MQTT broker\n";

$client->subscribe('ride/request', function (string $topic, string $message) use ($client, $driverName, $driverId) {
    $data = json_decode($message, true);
    if (!$data || !isset($data['ride_id'])) {
        return;
    }

    $rideId = $data['ride_id'];
    echo "\n NEW RIDE REQUEST #{$rideId}\n";
    echo " From: " . ($data['pickup']['address'] ?? 'N/A') . "\n";
    echo " Fare: TZS " . number_format($data['fare'] ?? 0) . "\n";

    // Step 1: Accept ride (1s delay)
    sleep(1);
    echo "\n Step 1: Accepting ride...\n";
    $client->publish(
        'ride/status/' . $rideId,
        json_encode([
            'ride_id' => $rideId,
            'status' => 'accepted',
            'driver' => [
                'id' => $driverId,
                'name' => $driverName,
                'phone' => '255712345678',
                'bike_plate' => 'MC 100 XY',
            ],
            'timestamp' => date('c'),
        ]),
        MqttClient::QOS_AT_LEAST_ONCE
    );
    echo "  Published: ride/status/{$rideId} → accepted\n";

    // Step 2: Driver arriving (2s delay)
    sleep(2);
    echo " Step 2: Driver arriving...\n";
    $client->publish(
        'ride/status/' . $rideId,
        json_encode([
            'ride_id' => $rideId,
            'status' => 'driver_arriving',
            'timestamp' => date('c'),
        ])
    );
    echo "  Published: ride/status/{$rideId} → driver_arriving\n";

    // Step 3: Trip started (3s delay)
    sleep(3);
    echo " Step 3: Trip started...\n";
    $client->publish(
        'ride/status/' . $rideId,
        json_encode([
            'ride_id' => $rideId,
            'status' => 'ongoing',
            'timestamp' => date('c'),
        ])
    );
    echo "  Published: ride/status/{$rideId} → ongoing\n";

    // Step 4: Trip completed (4s delay)
    sleep(4);
    echo " Step 4: Trip completed!\n";
    $client->publish(
        'ride/status/' . $rideId,
        json_encode([
            'ride_id' => $rideId,
            'status' => 'completed',
            'fare' => $data['fare'] ?? 5000,
            'distance' => $data['distance'] ?? 4.5,
            'timestamp' => date('c'),
        ])
    );
    echo "  Published: ride/status/{$rideId} → completed\n";
    echo "\n Ride lifecycle complete. Waiting for next request...\n";
}, MqttClient::QOS_AT_LEAST_ONCE);

echo " Waiting for ride requests... (Ctrl+C to stop)\n";
$client->loop(true);
