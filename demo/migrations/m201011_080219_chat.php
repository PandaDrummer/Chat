<?php

use yii\db\Migration;

/**
 * Class m201011_080219_chat
 */
class m201011_080219_chat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('chat', [
            'id' => $this->primaryKey(),
            'message' =>$this->text(),
            'user_id' =>$this->integer(),
            'status'=>$this->integer()->defaultValue(1)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201011_080219_chat cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201011_080219_chat cannot be reverted.\n";

        return false;
    }
    */
}
