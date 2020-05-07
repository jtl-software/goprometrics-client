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
        array $buckets = [0.005, 0.01, 0.025, 0.05, 0.075, 0.1, 0.25, 0.5, 0.75, 1.0, 2.5, 5.0, 7.5, 10.0],
        ?LabelList $tagList = null,
        string $help = ''
    ): void {
        $tagStr = $tagList !== null ? $tagList->toString() : '';
        $bucketStr = $this->createBucketString($buckets);
        $this->client->request(
            'PUT',
            "{$this->baseUrl}/observe/{$namespace}/{$name}/{$value}",
            [
                'body' => "labels=$tagStr&buckets={$bucketStr}&help=$help",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );
    }

    /**
     * @param array $buckets
     * @return string
     */
    private function createBucketString(array $buckets): string
    {
        $string = '';
        foreach ($buckets as $bucket) {
            $string .= (empty($string) ? $bucket : ',' . $bucket);
        }
        return $string;
    }
}
