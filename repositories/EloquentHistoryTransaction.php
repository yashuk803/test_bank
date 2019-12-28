<?php

namespace app\repositories;

use app\models\HistoryTransaction;
use app\repositories\contracts\HistoryTransactionRepository;

final class EloquentHistoryTransaction implements HistoryTransactionRepository
{

    public function save(HistoryTransaction $historyTransaction): HistoryTransaction
    {
        $historyTransaction->save();

        return $historyTransaction;
    }


    public function getStatisticByMonth()
    {
        return HistoryTransaction::find()
            ->select(['SUM(sum) sum' , 'created_on', 'type'])
            ->groupBy(['MONTH(created_on)', 'type'])
            ->all();
    }
}
