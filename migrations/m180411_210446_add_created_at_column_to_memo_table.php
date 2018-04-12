<?php

use yii\db\Migration;

/**
 * Handles adding created_at to table `memo`.
 */
class m180411_210446_add_created_at_column_to_memo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('memo', 'created_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('memo', 'created_at');
    }
}
