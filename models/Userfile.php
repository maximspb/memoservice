<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userfile".
 *
 * @property int $id
 * @property string $filename
 * @property int $memo_id
 */
class Userfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userfile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filename'], 'required'],
            [['filename'], 'string', 'max' => 255],
            ['memo_id', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Загруженный файл',
        ];
    }

    /**
     * @inheritdoc
     * @return UserfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserfileQuery(get_called_class());
    }
}
