<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recipient".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $job
 */
class Recipient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recipient';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'job'], 'required'],
            [['name', 'email'], 'string', 'max' => 50],
            [['job'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'ФИО',
            'email' => 'Email',
            'job' => 'Должность',
        ];
    }

    /**
     * @inheritdoc
     * @return RecipientQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RecipientQuery(get_called_class());
    }
}
