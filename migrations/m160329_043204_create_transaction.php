<?php

use yii\db\Migration;

class m160329_043204_create_transaction extends Migration {

    public function up()
    {
        $this->createTable('transaction', [
            'id' => $this->primaryKey(),
            'transaction_id' => $this->string(255)->notNull()->unique(),
            'sender_id' => $this->integer()->notNull(),
            'recipient_id' => $this->integer()->notNull(),
            'cost' => $this->decimal(10, 2)->notNull(),
            'type_id' => $this->integer()->notNull(),
            'protect_code' => $this->string(255),
            'status_id' => $this->integer()->notNull(),
        ]);
        $this->createIndex('idx-sender_id', 'transaction', 'sender_id');
        $this->createIndex('idx-recipient_id', 'transaction', 'recipient_id');
        $this->addForeignKey('fk-sender_id', 'transaction', 'sender_id', 'user', 'id', 'CASCADE');
        $this->addForeignKey('fk-recipient_id', 'transaction', 'recipient_id', 'user', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('transaction');
    }

}
