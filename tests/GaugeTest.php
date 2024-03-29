<?php

declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\GoPrometrics\Client\Gauge
 */
class GaugeTest extends TestCase
{
    public function testCanInc(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new LabelList();
        $tagList[] = new Label('foo', 'bar');

        $baseUri = uniqid('baseUri', true);
        $configurator = new DefaultGoPometricsConfigurator();
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/gauge/{$namespace}/{$name}/1",
            [
                'body' => "labels=foo%3Abar&help=This could be helpful&useSet=0",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Gauge($clientMock, $configurator, $baseUri);
        $counter->inc($namespace, $name, $tagList, 'This could be helpful');
    }

    public function testCanIncBy(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new LabelList();
        $tagList[] = new Label('foo', 'bar');

        $baseUri = uniqid('baseUri', true);
        $configurator = new DefaultGoPometricsConfigurator();
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/gauge/{$namespace}/{$name}/2",
            [
                'body' => "labels=foo%3Abar&help=This could be helpful&useSet=0",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Gauge($clientMock, $configurator, $baseUri);
        $counter->incBy($namespace, $name, 2, $tagList, 'This could be helpful');
    }

    public function testCanDec(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new LabelList();
        $tagList[] = new Label('foo', 'bar');

        $baseUri = uniqid('baseUri', true);
        $configurator = new DefaultGoPometricsConfigurator();
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/gauge/{$namespace}/{$name}/-1",
            [
                'body' => "labels=foo%3Abar&help=This could be helpful&useSet=0",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Gauge($clientMock, $configurator, $baseUri);
        $counter->dec($namespace, $name, $tagList, 'This could be helpful');
    }

    public function testCanDecBy(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new LabelList();
        $tagList[] = new Label('foo', 'bar');

        $baseUri = uniqid('baseUri', true);
        $configurator = new DefaultGoPometricsConfigurator();
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/gauge/{$namespace}/{$name}/-2",
            [
                'body' => "labels=foo%3Abar&help=This could be helpful&useSet=0",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Gauge($clientMock, $configurator, $baseUri);
        $counter->decBy($namespace, $name, 2, $tagList, 'This could be helpful');
    }

    public function testCanSet(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new LabelList();
        $tagList[] = new Label('foo', 'bar');

        $baseUri = uniqid('baseUri', true);
        $configurator = new DefaultGoPometricsConfigurator();
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/gauge/{$namespace}/{$name}/2",
            [
                'body' => "labels=foo%3Abar&help=This could be helpful&useSet=1",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Gauge($clientMock, $configurator, $baseUri);
        $counter->set($namespace, $name, 2, $tagList, 'This could be helpful');
    }
}
