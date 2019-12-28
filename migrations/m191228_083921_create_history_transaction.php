<?php

use yii\db\Migration;

/**
 * Class m191228_083921_create_history_transaction
 */
class m191228_083921_create_history_transaction extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableName = $this->db->tablePrefix . 'history_transactions';

        if (null === $this->db->getTableSchema($tableName, true)) {
            $this->createTable('crm.history_transactions', [
                'id' => $this->primaryKey(),
                'id_client_deposit' => $this->integer()->notNull(),
                'sum' => $this->decimal(19 , 4 ),
                'type' => "ENUM('Percent', 'Commission')",
                'created_on' => $this->dateTime(),
            ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

            $this->addForeignKey(
                'fk-history_transactions-id_client_deposit',
                'history_transactions',
                'id_client_deposit',
                'client_deposit',
                'id',
                'CASCADE'
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('crm.history_transactions');
    }
}
