<?php

use yii\db\Migration;

/**
 * Handles the creation of table `memo`.
 */
class m180411_040545_create_memo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('memo', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(250)->notNull(),
            'text' => $this->text()->notNull(),
            'ref_number' => $this->integer()->notNull(),
            'customDate'=> $this->string()->defaultValue(null),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()
        ]);

        $this->addForeignKey(
            'fk_memo_user_id',
            'memo',
            'user_id',
            'user',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('memo');
    }
}
