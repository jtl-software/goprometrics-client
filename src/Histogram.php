<?php declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

use GuzzleHttp\ClientInterface;

/**
 * This File is part of JTL-Software
 *
 * User: Milanowicz
 * Date: 2020-05-06
 */
class Histogram
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
     * @param float $value
     * @param array|float[] $buckets
     * @param LabelList|null $tagList
     * @param string $help
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function observe(
        string $namespace,
        string $name,
        float $value,
        array $buckets = [],
        LabelList $tagList = null,
        string $help = ''
    ): void {
        $tagStr = $tagList !== null ? $tagList->__toString() : '';
        $bucketStr = implode(',', $buckets);
        $this->client->request(
            'PUT',
            "{$this->baseUrl}/observe/{$namespace}/{$name}/{$value}",
            [
                'body' => "labels={$tagStr}&buckets={$bucketStr}&help={$help}",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );
    }
}
