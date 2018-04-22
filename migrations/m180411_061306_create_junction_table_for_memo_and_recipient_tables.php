<?php

use yii\db\Migration;

/**
 * Handles the creation of table `memo_recipient`.
 * Has foreign keys to the tables:
 *
 * - `memo`
 * - `recipient`
 */
class m180411_061306_create_junction_table_for_memo_and_recipient_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('memo_recipient', [
            'memo_id' => $this->integer(),
            'recipient_id' => $this->integer(),
            'PRIMARY KEY(memo_id, recipient_id)',
        ]);

        // creates index for column `memo_id`
        $this->createIndex(
            'idx-memo_recipient-memo_id',
            'memo_recipient',
            'memo_id'
        );

        // add foreign key for table `memo`
        $this->addForeignKey(
            'fk-memo_recipient-memo_id',
            'memo_recipient',
            'memo_id',
            'memo',
            'id',
            'CASCADE'
        );

        // creates index for column `recipient_id`
        $this->createIndex(
            'idx-memo_recipient-recipient_id',
            'memo_recipient',
            'recipient_id'
        );

        // add foreign key for table `recipient`
        $this->addForeignKey(
            'fk-memo_recipient-recipient_id',
            'memo_recipient',
            'recipient_id',
            'recipient',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `memo`
        $this->dropForeignKey(
            'fk-memo_recipient-memo_id',
            'memo_recipient'
        );

        // drops index for column `memo_id`
        $this->dropIndex(
            'idx-memo_recipient-memo_id',
            'memo_recipient'
        );

        // drops foreign key for table `recipient`
        $this->dropForeignKey(
            'fk-memo_recipient-recipient_id',
            'memo_recipient'
        );

        // drops index for column `recipient_id`
        $this->dropIndex(
            'idx-memo_recipient-recipient_id',
            'memo_recipient'
        );

        $this->dropTable('memo_recipient');
    }
}
