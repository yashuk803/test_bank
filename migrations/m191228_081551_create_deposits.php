<?php

use yii\db\Migration;

/**
 * Class m191228_081551_create_deposits
 */
class m191228_081551_create_deposits extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableName = $this->db->tablePrefix . 'deposits';

        if (null === $this->db->getTableSchema($tableName, true)) {
            $this->createTable('crm.deposits', [
                'id' => $this->primaryKey(),
                'name' => $this->string(255),
                'percent' => $this->float(),
            ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

            $this->insert('crm.deposits', [
                'name'=>'new 20',
                'percent'=> 0.2,
            ]);

            $this->insert('crm.deposits', [
                'name'=>'new 50',
                'percent'=> 0.5,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('crm.deposits');
    }
}
