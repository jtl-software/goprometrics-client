<?php declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

use GuzzleHttp\ClientInterface;

/**
 * This File is part of JTL-Software
 *
 * User: Milanowicz
 * Date: 2020-05-07
 */
class Gauge
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function inc(
        string $namespace,
        string $name,
        LabelList $tagList = null,
        string $help = ''
    ): void {
        $this->sendRequest($namespace, $name, 1, $tagList, $help);
    }

    /**
     * @param string $namespace
     * @param string $name
     * @param float $value
     * @param LabelList|null $tagList
     * @param string $help
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function incBy(
        string $namespace,
        string $name,
        float $value,
        LabelList $tagList = null,
        string $help = ''
    ): void {
        $this->sendRequest($namespace, $name, $value, $tagList, $help);
    }

    /**
     * @param string $namespace
     * @param string $name
     * @param LabelList|null $tagList
     * @param string $help
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function dec(
        string $namespace,
        string $name,
        LabelList $tagList = null,
        string $help = ''
    ): void {
        $this->sendRequest($namespace, $name, -1, $tagList, $help);
    }

    /**
     * @param string $namespace
     * @param string $name
     * @param float $value
     * @param LabelList|null $tagList
     * @param string $help
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function decBy(
        string $namespace,
        string $name,
        float $value,
        LabelList $tagList = null,
        string $help = ''
    ): void {
        $this->sendRequest($namespace, $name, $value * (-1), $tagList, $help);
    }

    /**
     * @param string $namespace
     * @param string $name
     * @param float $value
     * @param LabelList|null $tagList
     * @param string $help
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function sendRequest(
        string $namespace,
        string $name,
        float $value,
        LabelList $tagList = null,
        string $help = ''
    ): void {
        $tagStr = (string) $tagList;
        $this->client->request(
            'PUT',
            "{$this->baseUrl}/gauge/{$namespace}/{$name}/{$value}",
            [
                'body' => "labels={$tagStr}&help={$help}",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );
    }
}
