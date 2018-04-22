<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $last_name
 * @property string $initials
 * @property string $job
 * @property string $telephone
 * @property string $gender
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'auth_key', 'password_hash'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['email', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            ['password_reset_token', 'unique'],
            ['last_name', 'string', 'max' => 50],
            ['last_name', 'required'],
            ['genitive', 'string'],
            ['genitive', 'required'],
            ['initials', 'required'],
            ['job', 'required'],
            ['job_genitive', 'string'],
            ['job_genitive', 'required'],
            ['initials', 'string', 'max' => 6],
            ['job', 'string', 'max' => 100],
            ['telephone', 'string', 'max' => 10],


        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE] = [
            'email',
            'job',
            'last_name',
            'initials',
            'telephone',
            'job_genitive',
        ];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'job' => 'Должность',
            'last_name' => 'Фамилия',
            'genitive' => 'Фамилия в родительном падеже ("от кого")',
            'initials' => 'Инициалы',
            'created_at' => 'Время создания',
            'updated_at' => 'Время обновления',
            'telephone' => 'Внутренний телефон',
            'job_genitive' => 'Должность в родительном падеже (полностью)',
        ];
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */


    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }


    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }


    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $auth = Yii::$app->authManager;
        if ($this->isNewRecord) {
            $userRole = $auth->getRole('worker');
            $auth->assign($userRole, $this->getId());
        }
    }
}
