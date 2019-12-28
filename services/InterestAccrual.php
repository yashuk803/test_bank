<?php

namespace app\services;

use app\models\ClientDeposit;
use app\models\HistoryTransaction;
use app\repositories\contracts\ClientDepositRepository;
use app\repositories\contracts\HistoryTransactionRepository;
use Yii;

class InterestAccrual
{

    public $clientDepositRepository;
    public $historyTransactionRepository;

    public function __construct(
        ClientDepositRepository $clientDepositRepository,
        HistoryTransactionRepository $historyTransactionRepository
    )
    {
        $this->clientDepositRepository = $clientDepositRepository;
        $this->historyTransactionRepository = $historyTransactionRepository;
    }

    public function execute()
    {
       $itemsClientDeposit = $this->clientDepositRepository->findNextDateInterestAccrual();

       if(empty($itemsClientDeposit)) {
           return;
       }

       $currentDate = \date('Y-m-d H:i:s');

       foreach ($itemsClientDeposit as $item) {


           $transaction = Yii::$app->db->beginTransaction();

           try {
               $percentSum = $this->getSumPercent($item);

               $item->sum = $percentSum + $item->sum;
               $item->next_date_interest_accrual = $this->getNextDateInterestAccrual($item);
               $item->update_on = $currentDate;
               $this->clientDepositRepository->save($item);

               $modelHistoryTransaction = new HistoryTransaction();

               $modelHistoryTransaction->id_client_deposit = $item->id;
               $modelHistoryTransaction->sum = $percentSum;
               $modelHistoryTransaction->type = HistoryTransaction::TYPE_PERCENT;
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

    private function getSumPercent(ClientDeposit $item)
    {
        return $item->sum * $item->deposit->percent;
    }

    private function getNextDateInterestAccrual(ClientDeposit $item)
    {
        $lastDay = \date('t', \strtotime($item->next_date_interest_accrual));
        $currentDay = \date('j', \strtotime($item->next_date_interest_accrual));

        if($lastDay === $currentDay) {
            $format = 'Y-m-t';
        } else {
            $format = 'Y-m-d';
        }

        return \date($format, \strtotime('+1 MONTH', \strtotime($item->next_date_interest_accrual)));
    }

}
