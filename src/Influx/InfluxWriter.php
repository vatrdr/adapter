<?php

declare(strict_types=1);

namespace VatRadar\Adapter\Influx;

use InfluxDB2\Client as InfluxClient;
use InfluxDB2\Model\WritePrecision;
use InfluxDB2\WriteApi;
use InfluxDB2\WriteType;
use Psr\Http\Client\ClientInterface as HttpClient;

class InfluxWriter implements InfluxInterface
{

    private InfluxClient $influxClient;
    private WriteApi $writer;

    public function __construct(
        private readonly HttpClient $httpClient,
        private readonly Config $config
    ) {
        $this->influxClient = new InfluxClient($this->configToArray());
        $this->writer = $this->getClient()->createWriteApi(['writeType' => WriteType::BATCHING, 'batchSize' => $this->config->batchSize]);
    }

    private function configToArray(): array
    {
        return [
          'url' => $this->config->url,
          'token' => $this->config->token,
          'org' => $this->config->org,
          'precision' => WritePrecision::S,
          'httpClient' => $this->httpClient
        ];
    }

    public function getClient(): InfluxClient
    {
        return $this->influxClient;
    }

    public function getWriter(): WriteApi
    {
        return $this->writer;
    }
}
