<?php

namespace app\services\commission;

interface CommissionStrategyInterface
{
    public function getSumChargeCommission(float $sum, float $coefficient = 1): float;
}
