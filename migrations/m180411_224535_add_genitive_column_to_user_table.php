<?php

use yii\db\Migration;

/**
 * Handles adding genitive to table `user`.
 */
class m180411_224535_add_genitive_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'genitive', $this->string(55));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'genitive');
    }
}
