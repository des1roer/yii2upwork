<?php
use yii\db\Migration;
class m160329_054827_create_catalog extends Migration {

    public function up()
    {
        $this->createTable('type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unique()
        ]);

        $this->createTable('status', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unique()
        ]);

        $this->createIndex('idx-type_id', 'transaction', 'type_id');
        $this->createIndex('idx-status_id', 'transaction', 'status_id');
        $this->addForeignKey('fk-type_id', 'transaction', 'type_id', 'type', 'id', 'CASCADE');
        $this->addForeignKey('fk-status_id', 'transaction', 'status_id', 'status', 'id', 'CASCADE');

        Yii::$app->db->createCommand()->batchInsert('type', ['name'], [
            ['мгновенный'],
            ['с кодом протекции'],
            ['счет']
        ])->execute();
        Yii::$app->db->createCommand()->batchInsert('status', ['name'], [
            ['переведено'],
            ['ожидает оплаты'],
            ['возвращено'],
            ['отказано в возврате'],
            ['ожидание подтверждения']
        ])->execute();
    }

    public function down()
    {
        $this->dropTable('type');
        $this->dropTable('status');
    }

}
