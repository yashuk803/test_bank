<?php

namespace app\models;

class Client extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['identification_number', 'first_name', 'last_name', 'date_birthday', 'sex'], 'required'],
            [['identification_number', 'first_name', 'last_name', 'sex'], 'string'],
            [['date_birthday',], 'date'],
        ];
    }

}
