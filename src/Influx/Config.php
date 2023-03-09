<?php

declare(strict_types=1);

namespace VatRadar\Adapter\Influx;

final class Config
{
    public function __construct(
        public readonly string $url,
        public readonly string $token,
        public readonly string $org,
        public readonly int $batchSize = 250
    ) {}
}
