<?php

namespace app\services;

use app\models\HistoryTransaction;
use app\repositories\contracts\ClientDepositRepository;
use app\repositories\contracts\HistoryTransactionRepository;
use Yii;

class ChargeCommission
{

    public $clientDepositRepository;
    public $historyTransactionRepository;
    public $factory;

    private $coefficient = 1;

    public function __construct(
        ClientDepositRepository $clientDepositRepository,
        HistoryTransactionRepository $historyTransactionRepository,
        FactoryCommission $factory
    )
    {
        $this->clientDepositRepository = $clientDepositRepository;
        $this->historyTransactionRepository = $historyTransactionRepository;
        $this->factory = $factory;
    }

    public function execute()
    {
        $itemsClientDeposit = $this->clientDepositRepository->findAll();

        if(empty($itemsClientDeposit)) {
            return;
        }

        $currentDate = \date('Y-m-d H:i:s');

        foreach ($itemsClientDeposit as $item) {

            try {
                $date1 = new \DateTime($currentDate);
                $date2 = new \DateTime($item->created_on);

            } catch (\Exception $e) {
               continue;
            }

            $interval = $date2->diff($date1);



            if($interval->y === 0 && $interval->m < 1) {

                $this->setCoefficient($item->created_on);
            }

            $transaction = Yii::$app->db->beginTransaction();

            try {
                $commissionSum = $this->getSumCommission($item->sum);

                if($commissionSum  === 0) {
                    continue;
                }

                $item->sum = $item->sum - $commissionSum;

                $item->update_on = $currentDate;
                $this->clientDepositRepository->save($item);

                $modelHistoryTransaction = new HistoryTransaction();

                $modelHistoryTransaction->id_client_deposit = $item->id;
                $modelHistoryTransaction->sum = $commissionSum;
                $modelHistoryTransaction->type = HistoryTransaction::TYPE_COMMISSION;
                $modelHistoryTransaction->created_on = $currentDate;

                $this->historyTransactionRepository->save($modelHistoryTransaction);

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                continue;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                continue;
            }
        }
    }

    private function setCoefficient($date)
    {
        $lastDay = \date('t', \strtotime($date));
        $currentDay = \date('j', \strtotime($date));

        $this->coefficient =  $currentDay/$lastDay;
    }

    private function getCoefficient()
    {
        return $this->coefficient;
    }

    private function getSumCommission(float $sum)
    {

        $commission = 0;

        if($sum >= 0 &&  $sum < 1000) {
            $commission = $this->factory->createFivePercentCommission()->getSumChargeCommission($sum, $this->coefficient);
        } elseif($sum >= 1000 &&  $sum < 10000) {
            $commission = $this->factory->createSixPercentCommission()->getSumChargeCommission($sum, $this->coefficient);
        } elseif($sum >= 10000) {
            $commission = $this->factory->createSevenPercentCommission()->getSumChargeCommission($sum, $this->coefficient);
        }

        return $commission;
    }

}
