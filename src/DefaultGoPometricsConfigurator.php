<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 3/10/23
 */

namespace JTL\GoPrometrics\Client;

class DefaultGoPometricsConfigurator implements GoPometricsConfigurator
{
    public function extendLabelList(LabelList $labelList): LabelList
    {
        return $labelList;
    }

    public function isActive(): bool
    {
        return true;
    }
}
