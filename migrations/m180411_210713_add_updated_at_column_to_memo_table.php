<?php

use yii\db\Migration;

/**
 * Handles adding updated_at to table `memo`.
 */
class m180411_210713_add_updated_at_column_to_memo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('memo', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('memo', 'updated_at');
    }
}
