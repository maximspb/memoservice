<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Userfile */

$this->title = 'Create Userfile';
$this->params['breadcrumbs'][] = ['label' => 'Userfiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userfile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
