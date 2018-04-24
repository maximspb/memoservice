<?php

namespace app\models;

use yii\base\Model;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

/**
 * Класс загрузки исключительно
 * файла-изображения подписи
 * Class SignUploadForm
 * @package app\models
 */

class SignUploadForm extends Model
{
    public $userId;
    public $signFile;

    public function rules()
    {
        return [
            [['signFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png', 'maxFiles' => 1],
            ['userId', 'safe']
        ];
    }

    public function uploadFile()
    {
        if ($this->validate()) {

            if (!file_exists(__DIR__ . '/../web/uploads/'.$this->userId.'/sign/'
                ) && !is_dir(__DIR__ . '/../web/uploads/'.$this->userId.'/sign/')) {
                mkdir(__DIR__ . '/../web/uploads/'.$this->userId.'/sign/', $recursive = true);
            }

            $fullFileName = 'uploads/' .$this->userId.'/sign/'. 'sign'
                . '.' . $this->signFile->extension;
            $this->signFile->saveAs($fullFileName);

            Image::getImagine()
                ->open($fullFileName)
                ->thumbnail(new Box(150, 150))
                ->save($fullFileName , ['quality' => 100]);
            return true;
        } else {
            return false;
        }
    }
}