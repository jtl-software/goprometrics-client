<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-04-16
 */

namespace JTL\GoPrometrics\Client;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\GoPrometrics\Client\Counter
 */
class CounterTest extends TestCase
{
    public function testCanCount(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new LabelList();
        $tagList[]  = new Label('foo', 'bar');

        $baseUri = uniqid('baseUri', true);
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/count/{$namespace}/{$name}",
            [
                'body' => "labels=foo:bar",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Counter($clientMock, $baseUri);
        $counter->count($namespace, $name, $tagList);
    }
}
