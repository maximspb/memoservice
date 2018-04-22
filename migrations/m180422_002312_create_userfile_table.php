<?php

use yii\db\Migration;

/**
 * Handles the creation of table `userfile`.
 */
class m180422_002312_create_userfile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('userfile', [
            'id' => $this->primaryKey(),
            'filename'=>$this->string()->notNull(),
            'memo_id' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('userfile');
    }
}
