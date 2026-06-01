<?php

require __DIR__ . '/../vendor/autoload.php';

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

/**
 * MQTT Connection Test — used in CI pipeline
 *
 * Supports both anonymous (CI default) and authenticated (local) connections.
 *
 * Usage:
 *   php scripts/mqtt_test.php [host] [port] [username] [password]
 *
 * Defaults (anonymous):
 *   php scripts/mqtt_test.php 127.0.0.1 1883
 *
 * With auth:
 *   php scripts/mqtt_test.php localhost 1883 app_server B0dab0d@MQTT!
 */

$host = $argv[1] ?? '127.0.0.1';
$port = (int)($argv[2] ?? 1883);
$mqttUser = $argv[3] ?? null;
$mqttPass = $argv[4] ?? null;
$testId = 'test-' . uniqid();

echo " MQTT Connection Test\n";
echo " Broker: {$host}:{$port}\n";
echo "----------------------------------------\n";

try {
    $client = new MqttClient($host, $port, $testId);

    $settings = (new ConnectionSettings)->setKeepAliveInterval(30);
    if ($mqttUser) {
        $settings->setUsername($mqttUser)->setPassword($mqttPass);
        echo " [OK] Using authenticated connection\n";
    } else {
        echo " [OK] Using anonymous connection\n";
    }

    $client->connect($settings, true);
    echo " [OK] Connected to MQTT broker\n";

    $received = false;

    // Subscribe to response topic
    $client->subscribe('test/response', function (string $topic, string $message) use (&$received) {
        $data = json_decode($message, true);
        echo " [OK] Received: {$message}\n";
        if (isset($data['echo']) && $data['echo'] === 'pong') {
            $received = true;
            echo " [OK] Pub/Sub cycle verified!\n";
        }
    }, MqttClient::QOS_AT_LEAST_ONCE);

    // Publish ping
    $client->publish(
        'test/ping',
        json_encode([
            'test_id' => $testId,
            'message' => 'ping',
            'timestamp' => date('c'),
        ]),
        MqttClient::QOS_AT_LEAST_ONCE
    );
    echo " [OK] Published to test/ping\n";

    // Publish response (self-test: subscriber receives its own message)
    $client->publish(
        'test/response',
        json_encode([
            'test_id' => $testId,
            'echo' => 'pong',
            'timestamp' => date('c'),
        ]),
        MqttClient::QOS_AT_LEAST_ONCE
    );
    echo " [OK] Published to test/response\n";

    // Loop briefly to receive the message
    $client->loop(false);

    $client->disconnect();
    echo " [OK] Disconnected\n";

    if (!$received) {
        echo " [FAIL] Did not receive response message\n";
        exit(1);
    }

    echo "\n All MQTT tests passed!\n";
    exit(0);

} catch (\Exception $e) {
    echo " [FAIL] {$e->getMessage()}\n";
    echo "\n MQTT tests FAILED!\n";
    exit(1);
}
