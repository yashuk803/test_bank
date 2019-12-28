<?php

namespace app\services;

use app\services\commission\FivePercentCommissionStrategy;
use app\services\commission\SevenPercentCommissionStrategy;
use app\services\commission\SixPercentCommissionStrategy;

class FactoryCommission
{
    public function createFivePercentCommission(): FivePercentCommissionStrategy
    {
        return new FivePercentCommissionStrategy();
    }

    public function createSevenPercentCommission(): SevenPercentCommissionStrategy
    {
        return new SevenPercentCommissionStrategy();
    }

    public function createSixPercentCommission(): SixPercentCommissionStrategy
    {
        return new SixPercentCommissionStrategy();
    }

}
