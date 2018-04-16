<?php

use yii\db\Migration;

/**
 * Handles adding customDate to table `memo`.
 */
class m180416_075438_add_customDate_column_to_memo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('memo', 'customDate', $this->string()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
