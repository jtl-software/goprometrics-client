<?php
declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-04-14
 */
class Counter
{
    private ClientInterface $client;
    private string $baseUrl;

    public function __construct(ClientInterface $client, string $baseUrl)
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $namespace
     * @param string $name
     * @param LabelList|null $tagList
     * @param string $help
     * @param float $add
     * @throws GuzzleException
     */
    public function count(
        string $namespace,
        string $name,
        LabelList $tagList = null,
        string $help = '',
        float $add = 1.0
    ): void {
        $tagStr = (string)$tagList;
        $this->client->request(
            'PUT',
            "{$this->baseUrl}/count/{$namespace}/{$name}",
            [
                'body' => "labels={$tagStr}&help={$help}&add={$add}",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );
    }
}
