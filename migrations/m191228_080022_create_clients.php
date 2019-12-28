<?php

use yii\db\Migration;

/**
 * Class m191228_080022_create_clients
 */
class m191228_080022_create_clients extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableName = $this->db->tablePrefix . 'clients';

        if (null === $this->db->getTableSchema($tableName, true)) {
            $this->createTable('crm.clients', [
                'id' => $this->primaryKey(),
                'identification_number' => $this->string(20),
                'first_name' => $this->string(255),
                'last_name' => $this->string(255),
                'date_birthday' => $this->date(),
                'sex' => "ENUM('Male', 'Female') NOT NULL DEFAULT 'Male'",
            ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

            $this->insert('crm.clients', [
                'identification_number'=>'0125563689',
                'first_name'=>'Igor',
                'last_name'=>'Vulkanov',
                'date_birthday'=>'1986-12-03',
                'sex'=>'Male',
            ]);

            $this->insert('crm.clients', [
                'identification_number'=>'0125563689',
                'first_name'=>'Mariia',
                'last_name'=>'Vulkanov',
                'date_birthday'=>'1986-12-03',
                'sex'=>'Female',
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('crm.clients');
    }
}
