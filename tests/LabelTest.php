<?php

declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\GoPrometrics\Client\Label
 */
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
