<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Recipient]].
 *
 * @see Recipient
 */
class RecipientQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Recipient[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Recipient|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
