<?php

declare(strict_types=1);

namespace JTL\GoPrometrics\Client;

use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\GoPrometrics\Client\AbstractClient
 */
class AbstractClientTest extends TestCase
{
    /**
     * @test
     */
    public function itCanSendRequest(): void
    {
        $client = $this->createMock(ClientInterface::class);
        $configurator = $this->createMock(GoPometricsConfigurator::class);
        $testUrl = 'https://example.com';
        $sut = new class($client, $configurator, $testUrl) extends AbstractClient {
            public function send(string $url, string $body = '', string $httpMethod = 'PUT', array $headers = []): void
            {
                parent::send($url, $body, $httpMethod, $headers);
            }
        };

        $configurator->expects(self::once())
            ->method('isActive')
            ->willReturn(true);

        $client->expects(self::once())
            ->method('request')
            ->with(
                'BEER',
                '/foo/bar',
                [
                    'body' => 'my-body-rocks',
                    'headers' => [
                        'Content-Type' => "application/x-www-form-urlencoded",
                        'X-TEST-HEADER' => 'some-value'
                    ]
                ]
            );

        $sut->send('/foo/bar', 'my-body-rocks', 'BEER', ['X-TEST-HEADER' => 'some-value']);
    }

    /**
     * @test
     */
    public function itCanOverwriteContentTypeHeader(): void
    {
        $client = $this->createMock(ClientInterface::class);
        $configurator = $this->createMock(GoPometricsConfigurator::class);
        $testUrl = 'https://example.com';
        $sut = new class($client, $configurator, $testUrl) extends AbstractClient {
            public function send(string $url, string $body = '', string $httpMethod = 'PUT', array $headers = []): void
            {
                parent::send($url, $body, $httpMethod, $headers);
            }
        };

        $configurator->expects(self::once())
            ->method('isActive')
            ->willReturn(true);

        $client->expects(self::once())
            ->method('request')
            ->with(
                self::anything(),
                self::anything(),
                [
                    'body' => '',
                    'headers' => ['Content-Type' => "application/beer"]
                ]
            );

        $sut->send('', '', '', ['Content-Type' => 'application/beer']);
    }
}
