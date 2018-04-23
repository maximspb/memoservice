<?php

use app\models\User;
use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180406_104755_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique(),
            'last_name' => $this->string(50)->notNull(),
            'genitive' => $this->string(55)->notNull(),
            'initials' => $this->string(4)->notNull(),
            'job' => $this->string(100)->notNull(),
            'job_genitive' => $this->string()->notNull(),
            'telephone' => $this->string(10),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultValue(null),
            'updated_at' => $this->timestamp()->defaultValue(null),
        ], $tableOptions);
        //конфиг стартового пользователя создается вручную:
        $userConfig = require_once __DIR__ . '/../config/firstUserConfig.php';

        //внесение в базу данных первого пользователя в системе,
        // которому позднее через Rbac/init будет присвоен статус админа
        $this->insert('{{%user}}',
            [
                'email' =>$userConfig['email'],
                'last_name' => 'admin',
                'genitive' => 'admin',
                'initials' => 'A.A.',
                'job' => 'admin',
                'telephone' => '0000',
                'job_genitive' => 'admin',
                'auth_key' =>  \Yii::$app->security->generateRandomString(),
                'password_hash' =>\Yii::$app->security->generatePasswordHash($userConfig['password']),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
