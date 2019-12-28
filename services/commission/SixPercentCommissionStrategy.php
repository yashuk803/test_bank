<?php

namespace app\services\commission;

class SixPercentCommissionStrategy implements CommissionStrategyInterface
{
    const PERCENT = 0.06;

    public function getSumChargeCommission(float $sum, float $coefficient = 1): float
    {
        return $sum * self::PERCENT * $coefficient;
    }
}
