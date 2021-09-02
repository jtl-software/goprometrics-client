<?php declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

use GuzzleHttp\Exception\GuzzleException;

/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-04-14
 */
class Counter extends AbstractClient implements Counting
{
    /**
     * @param string $namespace
     * @param string $name
     * @param LabelList|null $tagList
     * @param string $help
     * @throws GuzzleException
     */
    public function count(string $namespace, string $name, LabelList $tagList = null, string $help = ''): void
    {
        $tagStr = (string) $tagList;
        $this->sendToServer(
            "{$this->baseUrl}/count/{$namespace}/{$name}",
            "labels={$tagStr}&help={$help}"
        );
    }
}
