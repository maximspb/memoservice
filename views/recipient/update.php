<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Recipient */

$this->title = 'Редактировать данные получателя';
$this->params['breadcrumbs'][] = ['label' => 'Получатели', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление данных';
?>
<div class="recipient-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
