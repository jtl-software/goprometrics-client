<?php

declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

class Counter extends AbstractClient implements CounterInterface
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
        string $help = '',
        float $add = 1.0
    ): void {
        if ($tagList !== null) {
            $tagList = $this->configurator->extendLabelList($tagList);
        }

        $this->send(
            "{$this->baseUrl}/count/{$namespace}/{$name}",
            "labels={$tagList}&help={$help}&add={$add}"
        );
    }
}
