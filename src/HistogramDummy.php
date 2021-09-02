<?php declare(strict_types=1);


namespace JTL\GoPrometrics\Client;

class HistogramDummy implements HistogramInterface
{
    /**
     * @param string $namespace
     * @param string $name
     * @param float $value
     * @param array $buckets
     * @param LabelList|null $tagList
     * @param string $help
     */
    public function observe(string $namespace, string $name, float $value, array $buckets = [], LabelList $tagList = null, string $help = ''): void
    {
    }
}
