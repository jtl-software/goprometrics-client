<?php

declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

class Gauge extends AbstractClient implements GaugeInterface
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
    public function set(
        string $namespace,
        string $name,
        float $value,
        LabelList $tagList = null,
        string $help = ''
    ): void {
        $this->sendRequest($namespace, $name, $value, $tagList, $help, true);
    }

    /**
     * @param string $namespace
     * @param string $name
     * @param float $value
     * @param LabelList|null $tagList
     * @param string $help
     * @param bool $useSet
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function sendRequest(
        string $namespace,
        string $name,
        float $value,
        LabelList $tagList = null,
        string $help = '',
        bool $useSet = false
    ): void {
        $useSetStr = $useSet ? '1' : 0;
        $this->send(
            "{$this->baseUrl}/gauge/{$namespace}/{$name}/{$value}",
            "labels={$tagList}&help={$help}&useSet={$useSetStr}"
        );
    }
}
