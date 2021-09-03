<?php

declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\GoPrometrics\Client\Histogram
 */
class HistogramTest extends TestCase
{
    public function testCanObserve(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new LabelList();
        $tagList[]  = new Label('foo', 'bar');

        $baseUri = uniqid('baseUri', true);
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/observe/{$namespace}/{$name}/0.002",
            [
                'body' => "labels=foo:bar&buckets=0.1,0.5,1,5&help=This could be helpful",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Histogram($clientMock, $baseUri);
        $counter->observe($namespace, $name, 0.002, [0.1, 0.5, 1.0, 5.0], $tagList, 'This could be helpful');
    }

    public function testCanObserveWithoutLabels(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);

        $baseUri = uniqid('baseUri', true);
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/observe/{$namespace}/{$name}/0.002",
            [
                'body' => "labels=&buckets=0.1,0.5,1,5&help=This could be helpful",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Histogram($clientMock, $baseUri);
        $counter->observe($namespace, $name, 0.002, [0.1, 0.5, 1.0, 5.0], null, 'This could be helpful');
    }
}
