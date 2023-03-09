<?php

declare(strict_types=1);

namespace VatRadar\Adapter\MQ;

final class Config {
    public function __construct(
        public readonly string $host,
        public readonly string $vHost,
        public readonly string $user,
        public readonly string $password
    ) {}
}
