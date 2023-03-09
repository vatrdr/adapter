<?php

declare(strict_types=1);

namespace VatRadar\Adapter\Redis;

interface RedisInterface
{
    public function getClient();
}
