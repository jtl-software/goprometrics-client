<?php

declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

use GuzzleHttp\ClientInterface;

abstract class AbstractClient
{
    private ?ClientInterface $client;
    protected string $baseUrl = '';

    public function __construct(
        ?ClientInterface $client = null,
        string $baseUrl = ''
    ) {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
    }

    public function getClient(): ?ClientInterface
    {
        return $this->client;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function sendToServer(
        string $url = '',
        string $body = '',
        string $restType = 'PUT',
        array $headers = ['Content-Type' => "application/x-www-form-urlencoded"]
    ): void {
        $this->client?->request(
            $restType,
            $url,
            [
                'body' => $body,
                'headers' => $headers
            ]
        );
    }
}
