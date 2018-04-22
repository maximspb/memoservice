<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Userfile]].
 *
 * @see Userfile
 */
class UserfileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Userfile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Userfile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
