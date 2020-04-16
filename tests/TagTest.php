<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-04-16
 */

namespace JTL\GoProm\Client;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\GoProm\Client\Tag
 */
class TagTest extends TestCase
{

    public function testCanBeUsed(): void
    {
        $key = uniqid('key', true);
        $value = uniqid('value', true);

        $tag = new Tag($key, $value);

        $this->assertSame($key, $tag->getKey());
        $this->assertSame($value, $tag->getValue());
    }
}
