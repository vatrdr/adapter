<?php

declare(strict_types=1);

namespace VatRadar\Adapter\MQ;

use Bunny\Async\Client as BunnyAsyncClient;
use React\EventLoop\LoopInterface;

/**
 * The initial centralized implementation is not much more than
 * a factory method. This will be expanded upon to provide
 * an abstraction point for the message queue.
 */
class AsyncMessageQueue implements MessageQueueInterface
{
    private BunnyAsyncClient $client;

    public function __construct(LoopInterface $loop, private readonly Config $config)
    {
        $this->client = new BunnyAsyncClient($loop, $this->configToArray());
        $this->client->connect();
    }

    public function __destruct()
    {
        $this->client->disconnect();
    }

    private function configToArray(): array
    {
        return [
            'host' => $this->config->host,
            'vhost' => $this->config->vHost,
            'user' => $this->config->user,
            'password' => $this->config->password
        ];
    }

    public function getClient(): BunnyAsyncClient
    {
        return $this->client;
    }
}
