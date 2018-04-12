<?php

namespace app\models;


use yii\base\Model;
use Yii;

class SignupForm extends Model
{
    public $email;
    public $password;
    public $last_name;
    public $initials;
    public $job;
    public $telephone;
    public $genitive;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
            ['genitive', 'string', 'max' => 55]
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'genitive' => 'Фамилия в родительном падеже ("от кого")',
            'initials' => 'Инициалы',
            'job' => 'Должность',
            'telephone' => 'Внутренний телефон',
            'last_name' => 'Фамилия',
            'password' => 'Пароль',
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
            $user->email = $this->email;
            $user->last_name = $this->last_name;
            $user->initials = $this->initials;
            $user->genitive = $this->genitive;
            $user->job = $this->job;
            $user->telephone = $this->telephone;
            $user->setPassword($this->password);
            $user->auth_key = Yii::$app->security->generateRandomString();
            return $user->save() ? $user : null;
        }

        return null;
    }

}