<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 3/15/23
 */

namespace JTL\GoPrometrics\Client;

use PHPUnit\Framework\TestCase;

/**
 * Class DefaultGoPometricsConfigurator
 *
 * @package JTL\GoPrometrics\Client
 *
 * @covers \JTL\GoPrometrics\Client\DefaultGoPometricsConfigurator
 */
class DefaultGoPometricsConfiguratorTest extends TestCase
{
    /**
     * @test
     */
    public function canExtendLabelList(): void
    {
        $configurator = new DefaultGoPometricsConfigurator();
        $labelList = new LabelList();

        self::assertTrue($configurator->isActive());
        self::assertSame($labelList, $configurator->extendLabelList($labelList));
    }
}
