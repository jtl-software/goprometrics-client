<?php

declare(strict_types=1);

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
        $configurator = new DefaultGoPometricsConfigurator();
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/count/{$namespace}/{$name}",
            [
                'body' => "labels=foo%3Abar&help=testing it",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Counter($clientMock, $configurator, $baseUri);
        $counter->count($namespace, $name, $tagList, 'testing it');
    }

    public function testCanCountWithoutLabels(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);

        $baseUri = uniqid('baseUri', true);
        $configurator = new DefaultGoPometricsConfigurator();
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/count/{$namespace}/{$name}",
            [
                'body' => "labels=&help=",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Counter($clientMock, $configurator, $baseUri);
        $counter->count($namespace, $name);
    }
}
