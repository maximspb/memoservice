<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $userFile =[];
    public $memo_id;

    public function rules()
    {
        return [
            [['userFile'], 'file', 'skipOnEmpty' => false, 'maxSize' => null, 'maxFiles' => 5],
            ['memo_id', 'safe']
        ];
    }

    public function uploadFile()
    {
        if ($this->validate()) {
            foreach ($this->userFile as $file) {
                $nameToSave = random_int(0, 99).$file->baseName . '.' . $file->
                    extension;
                $file->saveAs('uploads/' . $nameToSave);
                $uploaded = new Userfile();
                $uploaded->filename = $nameToSave;
                $uploaded->memo_id = $this->memo_id;
                $uploaded->save();
            }
            return true;
        } else {
            return false;
        }
    }





}