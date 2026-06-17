<?php

declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

class Label
{
    private readonly string $key;
    private readonly string $value;

    public function __construct(string $key, string $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
