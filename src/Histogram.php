<?php declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

use GuzzleHttp\Exception\GuzzleException;

/**
 * This File is part of JTL-Software
 *
 * User: Milanowicz
 * Date: 2020-05-06
 */
class Histogram extends AbstractClient implements Histograming
{
    /**
     * @param string $namespace
     * @param string $name
     * @param float $value
     * @param array|float[] $buckets
     * @param LabelList|null $tagList
     * @param string $help
     * @throws GuzzleException
     */
    public function observe(
        string $namespace,
        string $name,
        float $value,
        array $buckets = [],
        LabelList $tagList = null,
        string $help = ''
    ): void {
        $tagStr = (string) $tagList;
        $bucketStr = implode(',', $buckets);
        $this->sendToServer(
            "{$this->baseUrl}/observe/{$namespace}/{$name}/{$value}",
            "labels={$tagStr}&buckets={$bucketStr}&help={$help}"
        );
    }
}
