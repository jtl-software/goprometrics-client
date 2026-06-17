<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 3/15/23
 */

namespace JTL\GoPrometrics\Client;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Class DefaultGoPometricsConfigurator
 *
 * @package JTL\GoPrometrics\Client
 */
#[CoversClass(DefaultGoPometricsConfigurator::class)]
class DefaultGoPometricsConfiguratorTest extends TestCase
{
    #[Test]
    public function canExtendLabelList(): void
    {
        $configurator = new DefaultGoPometricsConfigurator();
        $labelList = new LabelList();

        self::assertTrue($configurator->isActive());
        self::assertSame($labelList, $configurator->extendLabelList($labelList));
    }
}
