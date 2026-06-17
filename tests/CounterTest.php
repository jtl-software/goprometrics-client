<?php

declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use GuzzleHttp\Client;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

#[CoversClass(Counter::class)]
class CounterTest extends TestCase
{
    #[Test]
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
            "{$baseUri}/count/{$namespace}/{$name}?add=1",
            [
                'body' => "labels=foo%3Abar&help=testing it",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Counter($clientMock, $configurator, $baseUri);
        $counter->count($namespace, $name, $tagList, 'testing it');
    }

    #[Test]
    public function testCanCountWithoutLabels(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);

        $baseUri = uniqid('baseUri', true);
        $configurator = new DefaultGoPometricsConfigurator();
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/count/{$namespace}/{$name}?add=1",
            [
                'body' => "labels=&help=",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Counter($clientMock, $configurator, $baseUri);
        $counter->count($namespace, $name);
    }

    #[Test]
    public function testCanAddCustomFloatValue(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);

        $baseUri = uniqid('baseUri', true);
        $configurator = new DefaultGoPometricsConfigurator();
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/count/{$namespace}/{$name}?add=3.14",
            [
                'body' => "labels=&help=",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Counter($clientMock, $configurator, $baseUri);
        $counter->count($namespace, $name, add: 3.14);
    }

    #[Test]
    public function testExtendedLabelListIsUsedWhenProvided(): void
    {
        $namespace = uniqid('namespace', true);
        $name = uniqid('name', true);
        $originalTagList = LabelList::create(['original' => 'label']);
        $extendedTagList = LabelList::create(['extended' => 'label']);

        $baseUri = uniqid('baseUri', true);

        /** @var GoPometricsConfigurator&MockObject $configurator */
        $configurator = $this->createMock(GoPometricsConfigurator::class);
        $configurator->expects(self::once())->method('isActive')->willReturn(true);
        $configurator->expects(self::once())
            ->method('extendLabelList')
            ->with($originalTagList)
            ->willReturn($extendedTagList);

        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())->method('request')->with(
            'PUT',
            "{$baseUri}/count/{$namespace}/{$name}?add=1",
            [
                'body' => "labels=extended%3Alabel&help=",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Counter($clientMock, $configurator, $baseUri);
        $counter->count($namespace, $name, $originalTagList);
    }
}
