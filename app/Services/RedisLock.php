<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class RedisLock
{
    private static int $defaultTtl = 10;

    public static function acquire(string $key, int $ttl = null): bool
    {
        $ttl = $ttl ?? self::$defaultTtl;
        $result = Redis::set("lock:$key", 'locked', 'EX', $ttl, 'NX');
        return $result !== null;
    }

    public static function release(string $key): void
    {
        Redis::del("lock:$key");
    }

    public static function withLock(string $key, callable $callback, int $ttl = null): mixed
    {
        if (!self::acquire($key, $ttl)) {
            throw new \RuntimeException("Could not acquire lock: $key. Try again.");
        }

        try {
            return $callback();
        } finally {
            self::release($key);
        }
    }
}
