<?php

declare(strict_types=1);

namespace VatRadar\Adapter\Cache;

use Psr\SimpleCache\CacheInterface as PsrSimpleCache;

interface CacheInterface extends PsrSimpleCache
{
    public function getClient();
}
