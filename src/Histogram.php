<?php

declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

class Histogram extends AbstractClient implements Histograming
{
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
        $bucketStr = implode(',', $buckets);
        $this->send(
            "{$this->baseUrl}/observe/{$namespace}/{$name}/{$value}",
            "labels={$tagList}&buckets={$bucketStr}&help={$help}"
        );
    }
}
