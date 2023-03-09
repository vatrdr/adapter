<?php

declare(strict_types=1);

namespace VatRadar\Adapter\Redis;

/**
 * Using this object is optional; it is here for future cases such as more
 * complex redis clusters/backends.
 */
class Config
{
    public function __construct(
        public readonly string $url
    ) {}
}
