<?php

use yii\db\Migration;

use yii\db\Schema;

/**
 * Class m180204_182611_create_table_user
 */
class m180204_182611_create_table_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING.'(255) NOT NULL',
            'password' => Schema::TYPE_STRING.'(255) NOT NULL',
            'authKey' => Schema::TYPE_STRING.'(255) NOT NULL',
            'accessToken' => Schema::TYPE_STRING.'(255) NOT NULL',
            'email' => Schema::TYPE_STRING.'(255) NOT NULL',
            
            
            "email" varchar(256) NOT NULL,
    "status" integer not null default 10,
    "created_at" integer not null,
    "updated_at" integer not null
        ]);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180204_182611_create_table_user cannot be reverted.\n";

        return false;
    }
    */
}
