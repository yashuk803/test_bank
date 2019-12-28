<?php

namespace app\services\commission;

class FivePercentCommissionStrategy implements CommissionStrategyInterface
{
    const PERCENT = 0.05;
    const MIN_SUM_COMMISSION = 50;

    public function getSumChargeCommission(float $sum, float $coefficient = 1): float
    {
        $sumCommission = $sum * self::PERCENT * $coefficient;

        if($sumCommission < self::MIN_SUM_COMMISSION) {
            $sumCommission = self::MIN_SUM_COMMISSION;
        }

        return $sumCommission;
    }
}
