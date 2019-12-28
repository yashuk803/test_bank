<?php

namespace app\services\commission;

class SevenPercentCommissionStrategy implements CommissionStrategyInterface
{
    const PERCENT = 0.07;
    const MAX_SUM_COMMISSION = 5000;

    public function getSumChargeCommission(float $sum, float $coefficient = 1): float
    {
        $sumCommission = $sum * self::PERCENT * $coefficient;

        if($sumCommission > self::MAX_SUM_COMMISSION) {
            $sumCommission = self::MAX_SUM_COMMISSION;
        }

        return $sumCommission;
    }
}
