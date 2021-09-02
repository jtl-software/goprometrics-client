<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: Milanowicz
 * Date: 2020-05-07
 */

namespace JTL\GoPrometrics\Client;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

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
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/gauge/{$namespace}/{$name}/1",
            [
                'body' => "labels=foo:bar&help=This could be helpful&useSet=0",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Gauge($clientMock, $baseUri);
        $counter->inc($namespace, $name, $tagList, 'This could be helpful');
    }

    public function testCanIncBy(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new LabelList();
        $tagList[] = new Label('foo', 'bar');

        $baseUri = uniqid('baseUri', true);
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/gauge/{$namespace}/{$name}/2",
            [
                'body' => "labels=foo:bar&help=This could be helpful&useSet=0",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Gauge($clientMock, $baseUri);
        $counter->incBy($namespace, $name, 2, $tagList, 'This could be helpful');
    }

    public function testCanDec(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new LabelList();
        $tagList[] = new Label('foo', 'bar');

        $baseUri = uniqid('baseUri', true);
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/gauge/{$namespace}/{$name}/-1",
            [
                'body' => "labels=foo:bar&help=This could be helpful&useSet=0",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Gauge($clientMock, $baseUri);
        $counter->dec($namespace, $name, $tagList, 'This could be helpful');
    }

    public function testCanDecBy(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new LabelList();
        $tagList[] = new Label('foo', 'bar');

        $baseUri = uniqid('baseUri', true);
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/gauge/{$namespace}/{$name}/-2",
            [
                'body' => "labels=foo:bar&help=This could be helpful&useSet=0",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Gauge($clientMock, $baseUri);
        $counter->decBy($namespace, $name, 2, $tagList, 'This could be helpful');
    }

    public function testCanSet(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new LabelList();
        $tagList[] = new Label('foo', 'bar');

        $baseUri = uniqid('baseUri', true);
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/gauge/{$namespace}/{$name}/2",
            [
                'body' => "labels=foo:bar&help=This could be helpful&useSet=1",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Gauge($clientMock, $baseUri);
        $counter->set($namespace, $name, 2, $tagList, 'This could be helpful');
    }

    public function testCanIncByDummy(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new LabelList();
        $tagList[] = new Label('foo', 'bar');

        $counter = new Gauge();
        $counter->inc($namespace, $name, $tagList, 'This could be helpful');
        $reflector = new ReflectionClass($counter);
        $method = $reflector->getProperty('client');
        $method->setAccessible(true);
        $this->assertNull($method->getValue($counter));
    }

    public function testCanIncByByDummy(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new LabelList();
        $tagList[] = new Label('foo', 'bar');

        $counter = new Gauge();
        $counter->incBy($namespace, $name, 2, $tagList, 'This could be helpful');
        $reflector = new ReflectionClass($counter);
        $method = $reflector->getProperty('client');
        $method->setAccessible(true);
        $this->assertNull($method->getValue($counter));
    }

    public function testCanDecByDummy(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new LabelList();
        $tagList[] = new Label('foo', 'bar');

        $counter = new Gauge();
        $counter->dec($namespace, $name, $tagList, 'This could be helpful');
        $reflector = new ReflectionClass($counter);
        $method = $reflector->getProperty('client');
        $method->setAccessible(true);
        $this->assertNull($method->getValue($counter));
    }

    public function testCanDecByByDummy(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new LabelList();
        $tagList[] = new Label('foo', 'bar');

        $counter = new Gauge();
        $counter->decBy($namespace, $name, 2, $tagList, 'This could be helpful');
        $reflector = new ReflectionClass($counter);
        $method = $reflector->getProperty('client');
        $method->setAccessible(true);
        $this->assertNull($method->getValue($counter));
    }

    public function testCanSetByDummy(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $tagList = new LabelList();
        $tagList[] = new Label('foo', 'bar');

        $counter = new Gauge();
        $counter->set($namespace, $name, 2, $tagList, 'This could be helpful');
        $reflector = new ReflectionClass($counter);
        $method = $reflector->getProperty('client');
        $method->setAccessible(true);
        $this->assertNull($method->getValue($counter));
    }
}
