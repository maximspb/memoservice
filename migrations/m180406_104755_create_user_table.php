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
            'last_name' =>$this->string(50)->notNull(),
            'genitive' => $this->string(55)->notNull(),
            'initials' => $this->string(4)->notNull(),
            'job' => $this->string(100)->notNull(),
            'telephone' => $this->string(10),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);
        //конфиг стартового пользователя создается вручную:
        $userConfig = require_once __DIR__.'/../config/firstUserConfig.php';
        $admin = new User();
        $admin->email = $userConfig['email'];
        $admin->last_name = 'admin';
        $admin->genitive ='admin';
        $admin->initials = 'A.A.';
        $admin->job = 'admin';
        $admin->telephone ='00';
        $admin->setPassword($userConfig['password']);
        $admin->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
