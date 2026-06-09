<?php

return [
    'host' => env('MQTT_HOST', 'mosquitto'),
    'port' => env('MQTT_PORT', 1883),
    'client_id' => env('MQTT_CLIENT_ID', 'bodaboda-backend'),
    'username' => env('MQTT_USERNAME', ''),
    'password' => env('MQTT_PASSWORD', ''),
    'client_username' => env('MQTT_CLIENT_USERNAME', ''),
    'client_password' => env('MQTT_CLIENT_PASSWORD', ''),
    'use_tls' => env('MQTT_USE_TLS', false),
    'qos' => env('MQTT_QOS', 1),
    'retain' => env('MQTT_RETAIN', false),

    'topics' => [
        'ride_request' => 'ride/request',
        'ride_status' => 'ride/status',
        'driver_location' => 'driver/location',
    ],
];
