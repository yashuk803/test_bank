<?php

namespace app\services;

use app\services\commission\CommissionStrategyInterface;

class Commission
{
    private $commission;

    public function __construct(CommissionStrategyInterface $commission)
    {
        $this->commission = $commission;
    }

    public function setCommissionStrategy(CommissionStrategyInterface $commission)
    {
        $this->commission = $commission;
    }

    public function getSumChargeCommission(float $sum, float $coefficient = 1): float
    {
        return $this->commission->getSumChargeCommission($sum, $coefficient);
    }
}
