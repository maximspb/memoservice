<?php

namespace app\models;


use yii\base\Model;
use Yii;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $last_name;
    public $initials;
    public $job;
    public $telephone;
    public $gender;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Такой логин уже занят'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Этот емэйл уже используется'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['last_name', 'string', 'max' => 50],
            [['last_name', 'initials', 'job'], 'required'],
            ['initials', 'string', 'max' => 6],
            ['job', 'string', 'max' => 100],
            ['last_name', 'string', 'max' => 50],
            ['telephone', 'string', 'max' => 10],
            ['gender', 'string', 'max' => 1]
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->last_name = $this->last_name;
            $user->initials = $this->initials;
            $user->job = $this->job;
            $user->telephone = $this->telephone;
            $user->gender = $this->gender;
            //$user->password_reset_token = $user->generatePasswordResetToken();
            $user->setPassword($this->password);
            $user->auth_key = Yii::$app->security->generateRandomString();

            return $user->save() ? $user : null;
        }

        return null;
    }

}