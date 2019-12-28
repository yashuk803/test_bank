<?php

namespace app\models;

class HistoryTransaction extends \yii\db\ActiveRecord
{
    const TYPE_PERCENT = 'Percent';
    const TYPE_COMMISSION = 'Commission';

    public static function tableName()
    {
        return 'history_transactions';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['created_on'], 'required'],
            [['created_on'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['id_client_deposit'], 'required'],
            [['id_client_deposit'], 'integer',],
            [['type'], 'required'],
            [['type'], 'string',],
        ];
    }

    public function getClientDeposit()
    {
        return $this->hasOne(ClientDeposit::class, ['id' => 'id_client_deposit']);
    }


}
