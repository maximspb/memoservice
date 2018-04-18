<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MemoRecipient]].
 *
 * @see MemoRecipient
 */
class MemoRecipientQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return MemoRecipient[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MemoRecipient|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
