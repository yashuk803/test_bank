<?php

namespace app\repositories\contracts;

use app\models\ClientDeposit;

interface ClientDepositRepository
{
    public function save(ClientDeposit $clientDeposit): ClientDeposit;

    public function findNextDateInterestAccrual();

    public function findAll();

    public function averageDepositAmountByGroup();
}
