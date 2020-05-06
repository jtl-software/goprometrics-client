<?php declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

use GuzzleHttp\ClientInterface;

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
     * @param LabelList $tagList
     * @param string $help
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function count(string $namespace, string $name, ?LabelList $tagList = null, string $help = ''): void
    {
        $tagStr = $this->createTagString($tagList);
        $this->client->request(
            'PUT',
            "{$this->baseUrl}/count/{$namespace}/{$name}",
            [
                'body' => "labels=$tagStr&help=$help",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );
    }

    private function createTagString(?LabelList $tagList = null): string
    {
        if ($tagList === null) {
            return '';
        }

        if (count($tagList) > 0) {
            $tagStrList = [];
            foreach ($tagList as $tag) {
                $tagStrList[] = "{$tag->getKey()}:{$tag->getValue()}";
            }
            $tagStr = implode(',', $tagStrList);
        }

        return $tagStr ?? '';
    }
}
