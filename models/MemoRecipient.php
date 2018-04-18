<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "memo_recipient".
 *
 * @property int $memo_id
 * @property int $recipient_id
 *
 * @property Memo $memo
 * @property Recipient $recipient
 */
class MemoRecipient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'memo_recipient';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['memo_id', 'recipient_id'], 'required'],
            [['memo_id', 'recipient_id'], 'integer'],
            [['memo_id', 'recipient_id'], 'unique', 'targetAttribute' => ['memo_id', 'recipient_id']],
            [['memo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Memo::className(), 'targetAttribute' => ['memo_id' => 'id']],
            [['recipient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipient::className(), 'targetAttribute' => ['recipient_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'memo_id' => 'Memo ID',
            'recipient_id' => 'Recipient ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMemo()
    {
        return $this->hasOne(Memo::className(), ['id' => 'memo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(Recipient::className(), ['id' => 'recipient_id']);
    }

    /**
     * @inheritdoc
     * @return MemoRecipientQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MemoRecipientQuery(get_called_class());
    }
}
