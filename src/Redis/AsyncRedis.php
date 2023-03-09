<?php

declare(strict_types=1);

namespace VatRadar\Adapter\Redis;

use Clue\React\Redis\RedisClient;
use React\EventLoop\LoopInterface;

/**
 * This class will need a lot of work. The Async Clue\RedisClient uses
 * the __call() magic method to implement all the redis commands, so
 * every call type used will likely need an adapter method here, otherwise
 * it's gonna get ugly.
 */
class AsyncRedis implements RedisInterface
{
    private RedisClient $client;

    public function __construct(LoopInterface $loop, private readonly Config|string $config)
    {
        if($this->config instanceof Config) {
            $url = $this->config->url;
        } else {
            $url = $this->config;
        }

        $this->client = new RedisClient(url: $url, loop: $loop);
    }

    public function __destruct()
    {
        $this->client->end();
    }

    public function getClient(): RedisClient
    {
        return $this->client;
    }
}
