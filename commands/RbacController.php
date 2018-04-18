<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {

        $auth = Yii::$app->authManager;

        $auth->removeAll();

        $admin = $auth->createRole('admin');
        $worker = $auth->createRole('worker');

        $auth->add($admin);
        $auth->add($worker);

        //Разрешение на создание служебки
        $createMemo = $auth->createPermission('createMemo');
        $createMemo->description = 'Создать служебку';
        $auth->add($createMemo);

        //Разрешение на обновление служебки
        $updateMemo = $auth->createPermission('updateMemo');
        $updateMemo->description = 'Редактировать служебку';
        $auth->add($updateMemo);

        //Разрешение на удаление служебки
        $deleteMemo = $auth->createPermission('deleteMemo');
        $deleteMemo->description = 'Удалить служебку';
        $auth->add($deleteMemo);

        //Разрешение на управление пользователями
        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Управлять пользователями';
        $auth->add($manageUsers);

        $auth->addChild($worker, $createMemo);

        $auth->addChild($admin, $updateMemo);

        $auth->addChild($admin, $worker);
        $auth->addChild($admin, $deleteMemo);
        $auth->addChild($admin, $manageUsers);

        $auth->assign($admin, 1);
    }
}