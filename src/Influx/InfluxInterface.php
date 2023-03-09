<?php

declare(strict_types=1);

namespace VatRadar\Adapter\Influx;

interface InfluxInterface
{
    public function getClient();

    public function getWriter();
}
