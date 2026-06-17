<?php

declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Label::class)]
class LabelTest extends TestCase
{
    public function testCanBeUsed(): void
    {
        $key = uniqid('key', true);
        $value = uniqid('value', true);

        $label = new Label($key, $value);

        $this->assertSame($key, $label->getKey());
        $this->assertSame($value, $label->getValue());
    }
}
