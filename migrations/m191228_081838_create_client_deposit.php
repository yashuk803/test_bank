<?php

use yii\db\Migration;

/**
 * Class m191228_081838_create_client_deposit
 */
class m191228_081838_create_client_deposit extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableName = $this->db->tablePrefix . 'client_deposit';

        if (null === $this->db->getTableSchema($tableName, true)) {
            $this->createTable('crm.client_deposit', [
                'id' => $this->primaryKey(),
                'id_client' => $this->integer()->notNull(),
                'id_deposit' => $this->integer()->notNull(),
                'sum' => $this->decimal(19 , 4 ),
                'next_date_interest_accrual' => $this->date(),
                'created_on' => $this->dateTime(),
                'update_on' => $this->dateTime(),
            ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

            $this->addForeignKey(
                'fk-client_deposit-id_client',
                'client_deposit',
                'id_client',
                'clients',
                'id',
                'CASCADE'
            );

            $this->addForeignKey(
                'fk-client_deposit-id_deposit',
                'client_deposit',
                'id_deposit',
                'deposits',
                'id',
                'CASCADE'
            );

            $this->insert('crm.client_deposit', [
                'id_client'=>1,
                'id_deposit'=>1,
                'sum'=>1000,
                'next_date_interest_accrual'=> date('y-m-d'),
                'created_on'=>'2019-12-28',
            ]);

            $this->insert('crm.client_deposit', [
                'id_client'=>1,
                'id_deposit'=>2,
                'sum'=>500,
                'next_date_interest_accrual'=> date('y-m-d'),
                'created_on'=>'2019-12-01',
            ]);

            $this->insert('crm.client_deposit', [
                'id_client'=>2,
                'id_deposit'=>1,
                'sum'=>500,
                'next_date_interest_accrual'=> date('y-m-d'),
                'created_on'=>'2019-12-01',
            ]);

        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('crm.client_deposit');
    }
}
