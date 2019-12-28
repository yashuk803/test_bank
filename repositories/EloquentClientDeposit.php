<?php

namespace app\repositories;

use app\models\ClientDeposit;
use app\repositories\contracts\ClientDepositRepository;

final class EloquentClientDeposit implements ClientDepositRepository
{

    public function save(ClientDeposit $clientDeposit): ClientDeposit
    {
        $clientDeposit->save();

        return $clientDeposit;
    }

    /**
     * @return ClientDeposit[]
     */
    public function findNextDateInterestAccrual(): array
    {
        return ClientDeposit::find()
            ->joinWith(['deposit'])
            ->where(['next_date_interest_accrual' => date('Y-m-d')])
            ->all();
    }

    public function findAll()
    {
        return ClientDeposit::find()
            ->with(['deposit'])
            ->all();
    }
}
