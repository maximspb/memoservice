<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Memo */

$this->title = 'Редактировать служебку';
$this->params['breadcrumbs'][] = ['label' => 'Все служебки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>'Касается: '. $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование служебки';
?>
<div class="memo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model, 'recipients' => $recipients,
    ]) ?>

</div>
