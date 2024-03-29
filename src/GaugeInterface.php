<?php

declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

interface GaugeInterface
{
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
    ): void;

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
    ): void;

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
    ): void;

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
    ): void;

    /**
     * @param string $namespace
     * @param string $name
     * @param float $value
     * @param LabelList|null $tagList
     * @param string $help
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function set(
        string $namespace,
        string $name,
        float $value,
        LabelList $tagList = null,
        string $help = ''
    ): void;
}
