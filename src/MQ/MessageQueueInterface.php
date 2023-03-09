<?php

declare(strict_types=1);

namespace VatRadar\Adapter\MQ;

interface MessageQueueInterface
{

    public function getClient();
}
