<?php

namespace JTL\GoPrometrics\Client;

interface CounterInterface
{
    /**
     * @param string $namespace
     * @param string $name
     * @param LabelList|null $tagList
     * @param string $help
     */
    public function count(string $namespace, string $name, LabelList $tagList = null, string $help = ''): void;
}
