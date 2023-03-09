<?php

declare(strict_types=1);

namespace VatRadar\Adapter\Cache;

use Stash\Driver\Redis;
use Stash\Pool;

class RedisCache implements CacheInterface
{
    private Pool $pool;

    public function __construct(private readonly Config $config)
    {
        $this->pool = new Pool(new Redis($this->configToArray()));
    }

    private function configToArray(): array
    {
        return [
            'servers' => [$this->config->host, $this->config->port]
        ];
    }

    public function getClient(): Pool
    {
        return $this->pool;
    }

    /**
     * @inheritDoc
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $item = $this->getClient()->getItem($key);

        if(!$item->isHit()) {
            return $default;
        }

        return $item->get();
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, mixed $value, \DateInterval|int|null $ttl = null): bool
    {
        $item = $this->getClient()->getItem($key);
        $item->set($value)->setTTL($ttl);
        return $this->getClient()->save($item);
    }

    /**
     * @inheritDoc
     */
    public function delete(string $key): bool
    {
        return $this->getClient()->deleteItem($key);
    }

    /**
     * @inheritDoc
     */
    public function clear(): bool
    {
        return $this->getClient()->clear();
    }

    /**
     * @inheritDoc
     */
    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $items = $this->getClient()->getItems($keys);

        if(count($items) < 1) {
            return $default;
        }

        return $items;
    }

    /**
     * @inheritDoc
     */
    public function setMultiple(iterable $values, \DateInterval|int|null $ttl = null): bool
    {
        foreach($values as $k => $v) {
            $item = $this->getClient()->getItem($k);
            $item->set($v)->setTTL($ttl);
            $this->getClient()->saveDeferred($item);
        }

        return $this->getClient()->commit();
    }

    /**
     * @inheritDoc
     */
    public function deleteMultiple(iterable $keys): bool
    {
        return $this->getClient()->deleteItems($keys);
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        return $this->getClient()->hasItem($key);
    }
}
