<?php

namespace app\models;


class Deposit extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'deposits';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
            [['percent',], 'required'],
            [['percent',], 'number'],
        ];
    }

}
