<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Recipient */

$this->title = 'Записать в базу данных нового адресата';
$this->params['breadcrumbs'][] = ['label' => 'Получатели служебок', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipient-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
