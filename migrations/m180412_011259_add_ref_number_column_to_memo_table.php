<?php

use yii\db\Migration;

/**
 * Handles adding ref_number to table `memo`.
 */
class m180412_011259_add_ref_number_column_to_memo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('memo', 'ref_number', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('memo', 'ref_number');
    }
}
