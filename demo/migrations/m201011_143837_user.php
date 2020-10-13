<?php

use yii\db\Migration;

/**
 * Class m201011_143837_user
 */
class m201011_143837_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' =>$this->string()->notNull(),
            'password' =>$this->string()->notNull(),
            'role'=>$this->integer()->defaultValue(1)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201011_143837_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201011_143837_user cannot be reverted.\n";

        return false;
    }
    */
}
