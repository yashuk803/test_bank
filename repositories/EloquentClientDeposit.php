<?php

namespace app\repositories;

use app\models\ClientDeposit;
use app\repositories\contracts\ClientDepositRepository;
use Yii;

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

    public function averageDepositAmountByGroup()
    {
        return Yii::$app->db->createCommand(
            "
                SELECT SUM(a.sum)/COUNT(*) as average, 'I group' as group_client  from (
                    SELECT
                    (YEAR(CURRENT_DATE)-YEAR(`date_birthday`))-(RIGHT(CURRENT_DATE,5) < RIGHT(`date_birthday`,5)) AS `age`,
                    b.sum
                    FROM crm.clients  a
                    INNER JOIN crm.client_deposit b ON a.id = b.id_client
                    HAVING `age` BETWEEN 18 AND 24
                ) a
                UNION 
                SELECT SUM(a.sum)/COUNT(*) as average, 'II group' as group_client  from (
                    SELECT
                    (YEAR(CURRENT_DATE) - YEAR(`date_birthday`)) - (RIGHT(CURRENT_DATE,5) < RIGHT(`date_birthday`,5)) 
                    AS `age`,
                    b.sum
                    FROM crm.clients  a
                    INNER JOIN crm.client_deposit b ON a.id = b.id_client
                    HAVING `age` BETWEEN 25 AND 49
                ) a
                UNION 
                SELECT SUM(a.sum)/COUNT(*) as average, 'III group' as group_client  from (
                    SELECT
                    (YEAR(CURRENT_DATE) - YEAR(`date_birthday`)) - (RIGHT(CURRENT_DATE,5) < RIGHT(`date_birthday`,5)) 
                    AS `age`,
                    b.sum
                    FROM crm.clients  a
                    INNER JOIN crm.client_deposit b ON a.id = b.id_client
                    HAVING `age` >= 50
                    ) a"
        )->queryAll();
    }
}
