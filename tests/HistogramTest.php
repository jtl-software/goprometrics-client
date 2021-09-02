<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: Milanowicz
 * Date: 2020-04-16
 */

namespace JTL\GoPrometrics\Client;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

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

    public function testCanObserveByDummy(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new LabelList();
        $tagList[]  = new Label('foo', 'bar');

        $counter = new Histogram();
        $counter->observe($namespace, $name, 0.002, [0.1, 0.5, 1.0, 5.0], $tagList, 'This could be helpful');
        $reflector = new ReflectionClass($counter);
        $method = $reflector->getProperty('client');
        $method->setAccessible(true);
        $this->assertNull($method->getValue($counter));
    }

    public function testCanObserveWithoutLabelsByDummy(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);

        $counter = new Histogram();
        $counter->observe($namespace, $name, 0.002, [0.1, 0.5, 1.0, 5.0], null, 'This could be helpful');
        $reflector = new ReflectionClass($counter);
        $method = $reflector->getProperty('client');
        $method->setAccessible(true);
        $this->assertNull($method->getValue($counter));
    }
}
