<?php

declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

interface Counting
{
    /**
     * @param string $namespace
     * @param string $name
     * @param LabelList|null $tagList
     * @param string $help
     */
    public function count(
        string $namespace,
        string $name,
        LabelList $tagList = null,
        string $help = ''
    ): void;
}
