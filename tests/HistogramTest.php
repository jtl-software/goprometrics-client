<?php

declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
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
                'body' => "labels=foo%3Abar&buckets=0.1,0.5,1,5&help=This could be helpful",
                'headers' => ['Content-Type' => "application/x-www-form-urlencoded"]
            ]
        );

        $counter = new Histogram($clientMock, $baseUri);
        $counter->observe($namespace, $name, 0.002, [0.1, 0.5, 1.0, 5.0], $tagList, 'This could be helpful');
    }

    public function testObserveValueCouldBeHandleFromServer(): void
    {
        // @see https://github.com/jtl-software/goprometrics/issues/11
        $namespace = 'testing';
        $name = 'test';
        $tagList = new LabelList();
        $tagList[]  = new Label('foo', 'bar');

        $counter = new Histogram(new Client(), 'http://127.0.0.1:9111');
        $counter->observe($namespace, $name, 0.0001, [0.0001, 0.5, 1.0], $tagList, 'This could be helpful');
        $client = new Client();
        $data = $client->request(
            'GET',
            'http://127.0.0.1:9112/metrics'
        );
        $metric = $data->getBody()->getContents();
        $this->assertStringContainsString('testing_test_bucket', $metric);
        $this->assertStringContainsString('testing_test_sum', $metric);
        $this->assertStringContainsString('testing_test_count', $metric);
    }

    public function testObserveValueTooSmallException(): void
    {
        // @see https://github.com/jtl-software/goprometrics/issues/11
        $namespace = 'testing';
        $name = 'test';
        $tagList = new LabelList();
        $tagList[]  = new Label('foo', 'bar');

        $this->expectException(ClientException::class);
        $counter = new Histogram(new Client(), 'http://127.0.0.1:9111');
        $counter->observe($namespace, $name, 0.000001, [0.001, 0.5, 1.0], $tagList, 'This could be helpful');
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
