<?php

declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

use GuzzleHttp\ClientInterface;

abstract class AbstractClient
{
    private ClientInterface $client;
    protected string $baseUrl;

    public function __construct(
        ClientInterface $client,
        string $baseUrl
    ) {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
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
        if (!isset($headers['Content-Type'])) {
            $headers['Content-Type'] = "application/x-www-form-urlencoded";
        }

        $this->client->request(
            $httpMethod,
            $url,
            [
                'body' => $body,
                'headers' => $headers
            ]
        );
    }
}
