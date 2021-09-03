<?php

declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

class Counter extends AbstractClient implements Counting
{
    /**
     * @param string $namespace
     * @param string $name
     * @param LabelList|null $tagList
     * @param string $help
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function count(
        string $namespace,
        string $name,
        LabelList $tagList = null,
        string $help = ''
    ): void {
        $tagStr = (string) $tagList;
        $this->send(
            "{$this->baseUrl}/count/{$namespace}/{$name}",
            "labels={$tagStr}&help={$help}"
        );
    }
}
