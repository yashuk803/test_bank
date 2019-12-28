<?php

namespace app\models;

class ClientDeposit extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'client_deposit';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['next_date_interest_accrual', 'created_on', 'update_on'], 'required'],
            [['next_date_interest_accrual'], 'date', 'format' => 'php:Y-m-d'],
            [['created_on', 'update_on'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['id_client', 'id_deposit'], 'required'],
            [['id_client', 'id_deposit'], 'integer'],
            [['sum'], 'required'],
            [['sum'], 'number'],
        ];
    }

    public function getDeposit()
    {
        return $this->hasOne(Deposit::class, ['id' => 'id_deposit']);
    }

    public function getHistoryTransactionsByCommission()
    {
        return $this
            ->hasOne(HistoryTransaction::class, ['id_client_deposit' => 'id'])
            ->onCondition(['type' => 'Commission']);
    }

}
