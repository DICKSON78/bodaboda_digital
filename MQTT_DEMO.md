# MQTT Real-Time Ride Tracking — Demo Guide

## Architecture

```
┌─────────────┐     MQTT (1883)    ┌──────────────┐    WebSocket (9001)  ┌──────────────┐
│  Laravel     │──────────────────→│  Mosquitto    │────────────────────→│  Browser      │
│  Backend     │                   │  Broker       │                     │  MQTT.js      │
│              │  ride/request     │              │                     │              │
│  Controllers │──────────────────→│              │                     │  Ride show   │
│  Jobs        │  ride/status/     │              │                     │  page        │
│              │  {id}/{token}     │              │                     │  subscribes  │
│              │──────────────────→│              │                     │              │
│              │  driver/location/ │              │                     │  Map updates │
│              │  {riderId}        │              │                     │  Status badge│
└─────────────┘                   └──────────────┘                    └──────────────┘
                                         ▲
                                         │
                                  ┌──────┴──────┐
                                  │  mosquitto_sub   │
                                  │  Postman MQTT    │
                                  │  (live monitor)  │
                                  └─────────────────┘
```

## MQTT Topics

| Topic | Direction | Purpose | Token-Protected |
|-------|-----------|---------|-----------------|
| `ride/request` | Backend → All drivers | Broadcast new ride requests | No |
| `ride/status/{rideId}/{rideToken}` | Backend → Specific passenger | Ride status updates (accepted, ongoing, completed, cancelled) | **Yes** — UUID token in path |
| `driver/location/{riderId}` | Backend → Specific passenger | Real-time GPS tracking marker | No (scoped by rider ID) |

## Prerequisites

- Docker containers running (`docker-compose up -d`)
- Mosquitto broker on ports `1883` (MQTT) and `9001` (WebSocket)
- App accessible at `http://localhost:8000`

## Getting Real Ride Tokens

```bash
docker exec bodaboda-db mysql -uroot -proot bodaboda \
  -e "SELECT id, ride_token, status FROM rides ORDER BY id DESC LIMIT 10;"
```

Example output:
```
id  ride_token                               status
3   e5a29730-e009-40d3-83cf-b6b0aecab736     completed
2   b1c9101b-fc30-4306-b90e-1be1937f42de     ongoing
1   e0c5544a-fc4e-4165-89db-58dfe32822ee     completed
```

Use the token with the ride ID to construct the topic: `ride/status/{id}/{token}`

---

## Demo 1 — Monitor MQTT Traffic (CLI)

Open 2 terminals:

**Terminal 1 — Subscribe to all topics:**
```bash
mosquitto_sub -h localhost -p 1883 \
  -u app_client -P 'Cli3ntMQTT!' \
  -t '#' -v
```

**Terminal 2 — Publish a status update:**
```bash
mosquitto_pub -h localhost -p 1883 \
  -u app_server -P 'B0dab0d@MQTT!' \
  -t 'ride/status/2/b1c9101b-fc30-4306-b90e-1be1937f42de' \
  -m '{"status":"accepted","ride_id":2,"ride_token":"b1c9101b-fc30-4306-b90e-1be1937f42de","driver":{"name":"Demo Rider","phone":"255712345678"}}'
```

You'll see the message appear in Terminal 1 instantly.

### Simulate a full ride lifecycle:

```bash
# Accept
mosquitto_pub -h localhost -p 1883 -u app_server -P 'B0dab0d@MQTT!' \
  -t 'ride/status/2/b1c9101b-fc30-4306-b90e-1be1937f42de' \
  -m '{"status":"accepted","ride_id":2,"ride_token":"b1c9101b-fc30-4306-b90e-1be1937f42de","driver":{"id":1,"name":"Demo","phone":"255712345678","bike_plate":"MC 100 XYZ"}}'

# Driver arriving
mosquitto_pub -h localhost -p 1883 -u app_server -P 'B0dab0d@MQTT!' \
  -t 'ride/status/2/b1c9101b-fc30-4306-b90e-1be1937f42de' \
  -m '{"status":"driver_arriving","ride_id":2,"ride_token":"b1c9101b-fc30-4306-b90e-1be1937f42de"}'

# Trip started
mosquitto_pub -h localhost -p 1883 -u app_server -P 'B0dab0d@MQTT!' \
  -t 'ride/status/2/b1c9101b-fc30-4306-b90e-1be1937f42de' \
  -m '{"status":"ongoing","ride_id":2,"ride_token":"b1c9101b-fc30-4306-b90e-1be1937f42de"}'

# Trip completed
mosquitto_pub -h localhost -p 1883 -u app_server -P 'B0dab0d@MQTT!' \
  -t 'ride/status/2/b1c9101b-fc30-4306-b90e-1be1937f42de' \
  -m '{"status":"completed","ride_id":2,"ride_token":"b1c9101b-fc30-4306-b90e-1be1937f42de","fare":5000}'
```

---

## Demo 2 — Postman MQTT Client

Postman v10+ has a built-in MQTT client.

1. Click **New** → **MQTT Client** (or Ctrl+K and search "MQTT")
2. Connect with:

   | Field | Value |
   |-------|-------|
   | Broker | `localhost` |
   | Port | `1883` |
   | Username | `app_client` |
   | Password | `Cli3ntMQTT!` |

3. **Subscribe** to a ride topic:

   | Field | Value |
   |-------|-------|
   | Topic | `ride/status/2/b1c9101b-fc30-4306-b90e-1be1937f42de` |
   | QoS | `1` |

4. **Publish** messages using the same format as Demo 1 above.

---

## Demo 3 — HTTP Endpoints (curl / Postman HTTP)

All endpoints accept `Accept: application/json` to return JSON instead of redirects.

### Authentication

First create test users (done by seeder). Login to get a session:

```bash
# Login as rider
curl -s -X POST http://localhost:8000/login \
  -H "Accept: application/json" \
  -d "email=rider@test.com&password=password" \
  -c cookies.txt | jq
```

### 1. Create a ride (anyone)

```
POST http://localhost:8000/rides
Headers: Accept: application/json
Body:
  pickup_lat=-6.1622
  pickup_lng=35.7516
  dest_lat=-6.1722
  dest_lng=35.7616
  distance=2.5
```

MQTT: publishes `ride/request`

### 2. Accept a ride (rider only)

```
POST http://localhost:8000/api/rides/{ride}/accept
Headers: Accept: application/json
```

MQTT: publishes `ride/status/{id}/{token}` with status `accepted`

### 3. Start trip (rider only)

```
POST http://localhost:8000/rides/{ride}/start
Headers: Accept: application/json
```

MQTT: publishes `ride/status/{id}/{token}` with status `ongoing`

### 4. Complete trip (rider only)

```
POST http://localhost:8000/rides/{ride}/complete
Headers: Accept: application/json
```

MQTT: publishes `ride/status/{id}/{token}` with status `completed`

### 5. Cancel ride (passenger)

```
POST http://localhost:8000/rides/{ride}/cancel
Headers: Accept: application/json
```

MQTT: publishes `ride/status/{id}/{token}` with status `cancelled`

### 6. Update ride status (rider only)

```
POST http://localhost:8000/api/rides/{ride}/status
Headers: Accept: application/json
Content-Type: application/json

{"status":"driver_arriving"}
```

Valid statuses: `driver_arriving`, `driver_arrived`, `ongoing`, `completed`, `cancelled`

MQTT: publishes `ride/status/{id}/{token}`

### 7. Update driver location (rider only)

```
POST http://localhost:8000/api/driver/location
Headers: Accept: application/json
Content-Type: application/json

{"lat":-6.7924,"lng":39.2083}
```

MQTT: publishes `driver/location/{riderId}`

### JSON Response Format

All endpoints return:
```json
{
  "success": true,
  "message": "Ride completed!",
  "mqtt": {
    "topic": "ride/status/2/b1c9101b-fc30-4306-b90e-1be1937f42de",
    "payload": {
      "ride_id": 2,
      "ride_token": "b1c9101b-fc30-4306-b90e-1be1937f42de",
      "status": "completed",
      "fare": 5000
    }
  }
}
```

### Full curl Demo Script

```bash
#!/bin/bash
RIDE_ID=2

# 1. Monitor MQTT in another terminal:
#    mosquitto_sub -h localhost -p 1883 -u app_client -P 'Cli3ntMQTT!' -t '#' -v

# 2. Accept a ride
curl -s -X POST "http://localhost:8000/api/rides/$RIDE_ID/accept" \
  -H "Accept: application/json" \
  -b cookies.txt | jq

# 3. Start
curl -s -X POST "http://localhost:8000/rides/$RIDE_ID/start" \
  -H "Accept: application/json" \
  -b cookies.txt | jq

# 4. Complete
curl -s -X POST "http://localhost:8000/rides/$RIDE_ID/complete" \
  -H "Accept: application/json" \
  -b cookies.txt | jq
```

---

## Demo 4 — Watch Real-Time in Browser

1. Create a ride via the web form at `/rides/create` or via curl
2. Copy the ride ID from the URL or response
3. Open `/rides/{id}` in a browser — shows Leaflet map + status badge
4. In another terminal, publish status updates with `mosquitto_pub`
5. Watch the status badge and map update in real-time — no page refresh needed

### GPS Tracking Demo

```bash
# Simulate a moving driver
lat=-6.7924
for i in $(seq 1 10); do
  lat=$(echo "$lat - 0.0005" | bc)
  mosquitto_pub -h localhost -p 1883 \
    -u app_server -P 'B0dab0d@MQTT!' \
    -t 'driver/location/1' \
    -m "{\"lat\":$lat,\"lng\":39.2083,\"rider_id\":1}"
  sleep 1
done
```

The marker on the map moves every second.

---

## Security — Token-Protected Topics

Each ride gets a random UUID `ride_token` on creation:

```
ride/status/42/550e8400-e29b-41d4-a716-446655440000
```

The token acts as a shared secret in the topic path — only the passenger and rider who know the token can subscribe to that ride's real-time updates. Even with valid MQTT credentials (`app_client`), an attacker cannot guess another ride's topic without the token.

---

## Writing Automated Tests

```bash
docker exec bodaboda-app php artisan test tests/Feature/MqttPublishTest.php
```

The test suite (`tests/Feature/MqttPublishTest.php`) mocks `MqttService` and verifies:
- Correct topic is used (with ride token in path)
- Correct payload structure per status
- Ride token is generated and unique
- Show page renders MQTT-related JavaScript

Example test:
```php
public function test_publishes_accepted_with_ride_token_topic()
{
    $mqtt = $this->createMock(MqttService::class);
    $mqtt->expects($this->once())
        ->method('publish')
        ->with(
            'ride/status/1/' . $ride->ride_token,
            $this->callback(fn($p) =>
                $p['status'] === 'accepted' && isset($p['driver'])
            )
        );
    $this->app->instance(MqttService::class, $mqtt);

    $this->actingAs($riderUser)->post(route('rides.accept', $ride->id));
}
```

---

## Credentials

| Role | Username | Password |
|------|----------|----------|
| MQTT Server publish | `app_server` | `B0dab0d@MQTT!` |
| MQTT Client subscribe | `app_client` | `Cli3ntMQTT!` |
| Admin web login | `admin@bodaboda.com` | `admin1234` |

---

## Troubleshooting

**Can't connect to Mosquitto?**
```bash
docker-compose ps mosquitto
# Ports should show 0.0.0.0:1883->1883/tcp, 0.0.0.0:9001->9001/tcp
```

**No rides in database?**
```bash
docker exec bodaboda-app php artisan migrate:fresh --seed
```

**Admin dashboard charts not loading?**
Turbo Drive replaces page body via AJAX — `DOMContentLoaded` only fires once. All admin scripts now use top-level code (no event wrapper) so they execute on every Turbo navigation.
