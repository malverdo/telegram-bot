<?php

namespace App\Infrastructure\Client;

use Predis\Client as RedisClient;

class PredisClient
{
    const REDIS_KEY_MESSAGE_ID = 'messageid:';
    private RedisClient $redis;

    public function __construct(RedisClient $redis)
    {
        $this->redis = $redis;
    }

    public function setex($key, $value, $time): void
    {
        $this->redis->setex($key, $time, $value);
    }

    public function get($key): ?string
    {
        return $this->redis->get($key);
    }

    public function delete($key): void
    {
         $this->redis->del($key);
    }
}