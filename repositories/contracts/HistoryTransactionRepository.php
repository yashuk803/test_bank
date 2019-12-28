<?php

namespace app\repositories\contracts;

use app\models\HistoryTransaction;

interface HistoryTransactionRepository
{
    public function save(HistoryTransaction $historyTransaction): HistoryTransaction;

    public function getStatisticByMonth();

}
