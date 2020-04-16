<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-04-16
 */

namespace JTL\GoProm\Client;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\GoProm\Client\Counter
 */
class CounterTest extends TestCase
{
    public function testCanCount(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new TagList();
        $tagList[]  = new Tag('foo', 'bar');

        $baseUri = uniqid('baseUri', true);
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with('PUT', "{$baseUri}/count/{$namespace}/{$name}/foo:bar");

        $counter = new Counter($clientMock, $baseUri);
        $counter->count($namespace, $name, $tagList);
    }
}
