<?php

namespace app\repositories;

use app\models\HistoryTransaction;
use app\repositories\contracts\HistoryTransactionRepository;
use Yii;

final class EloquentHistoryTransaction implements HistoryTransactionRepository
{

    public function save(HistoryTransaction $historyTransaction): HistoryTransaction
    {
        $historyTransaction->save();

        return $historyTransaction;
    }

    public function getStatisticByMonth()
    {
        return Yii::$app->db->createCommand(
            "
                Select DATE_FORMAT(a.created_on, \"%Y-%m\") date, 
                (CASE
                    WHEN b.sum is null THEN CONCAT('-', c.sum ) 
                    WHEN c.sum  is null THEN b.sum 
                    ELSE b.sum - c.sum
                END) sum from
                (SELECT created_on FROM crm.history_transactions group by created_on) a
                left join (select type, SUM(sum) sum, created_on from  crm.history_transactions where type = 'Commission' group by created_on) b
                on a.created_on = b.created_on
                left join (select type, SUM(sum) sum, created_on  from  crm.history_transactions where type = 'Percent' group by created_on) c
                on a.created_on = c.created_on
            
            "
        )->queryAll();
    }
}

