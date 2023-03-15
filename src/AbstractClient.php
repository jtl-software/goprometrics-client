<?php

declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

use GuzzleHttp\ClientInterface;

abstract class AbstractClient
{
    public function __construct(
        private readonly ClientInterface $client,
        protected readonly GoPometricsConfigurator $configurator,
        protected readonly string $baseUrl
    ) {
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function send(
        string $url,
        string $body = '',
        string $httpMethod = 'PUT',
        array $headers = []
    ): void {
        if (!$this->configurator->isActive()) {
            return;
        }

        if (!isset($headers['Content-Type'])) {
            $headers['Content-Type'] = "application/x-www-form-urlencoded";
        }

        $this->client->request(
            $httpMethod,
            $url,
            [
                'body' => $body,
                'headers' => $headers,
            ]
        );
    }
}
