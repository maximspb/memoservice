<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "memo".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $text
 * @property int $ref_number
 * @property User $user
 */
class Memo extends \yii\db\ActiveRecord
{
    public $recipientsList = [];
    public $customDate;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'memo';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function rules()
    {
        return [
            [['user_id', 'title', 'text'], 'required'],
            [['recipientsList'], 'safe'],
            [['user_id'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 250],
            ['ref_number', 'integer'],
            ['customDate', 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'text' => 'Text',
            'recipientsList' => 'recipientsList'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getRecipients()
    {
        return $this->hasMany(Recipient::class, ['id' => 'recipient_id'])
            ->viaTable('memo_recipient', ['memo_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return MemoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MemoQuery(get_called_class());
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (!empty($this->recipientsList)) {
        $listOfRecipients = $this->recipientsList;
            foreach ($listOfRecipients as $key => $id) {
                $setRecipients = new MemoRecipient();
                $setRecipients->memo_id = $this->id;
                $setRecipients->recipient_id = (int)$id;
                $setRecipients->save();
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeSave($insert)
    {
        if (empty($this->ref_number)) {
            $lastRefnumber = (int)(new \yii\db\Query())
                ->from('memo')
                ->orderBy('id DESC')
                ->limit(1)
                ->one()['ref_number'];
            $this->ref_number = $lastRefnumber + 1;
        }
        if (!empty($this->customDate)){
            $this->created_at = $this->customDate;
        }
        $this->user_id = Yii::$app->user->id;
        return parent::beforeSave($insert);
    }
}
