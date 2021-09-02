<?php declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

class GaugeDummy implements GaugeInterface
{
    /**
     * @param string $namespace
     * @param string $name
     * @param LabelList|null $tagList
     * @param string $help
     */
    public function inc(string $namespace, string $name, LabelList $tagList = null, string $help = ''): void
    {
    }

    /**
     * @param string $namespace
     * @param string $name
     * @param float $value
     * @param LabelList|null $tagList
     * @param string $help
     */
    public function incBy(string $namespace, string $name, float $value, LabelList $tagList = null, string $help = ''): void
    {
    }

    /**
     * @param string $namespace
     * @param string $name
     * @param LabelList|null $tagList
     * @param string $help
     */
    public function dec(string $namespace, string $name, LabelList $tagList = null, string $help = ''): void
    {
    }

    /**
     * @param string $namespace
     * @param string $name
     * @param float $value
     * @param LabelList|null $tagList
     * @param string $help
     */
    public function decBy(string $namespace, string $name, float $value, LabelList $tagList = null, string $help = ''): void
    {
    }

    /**
     * @param string $namespace
     * @param string $name
     * @param float $value
     * @param LabelList|null $tagList
     * @param string $help
     */
    public function set(string $namespace, string $name, float $value, LabelList $tagList = null, string $help = ''): void
    {
    }
}
