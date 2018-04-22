<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Memo */

$this->title = 'Создать служебку';
$this->params['breadcrumbs'][] = ['label' => 'Служебки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model, 'recipients' => $recipients
    ]) ?>

</div>
