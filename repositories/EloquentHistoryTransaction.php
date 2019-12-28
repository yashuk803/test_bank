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

}
