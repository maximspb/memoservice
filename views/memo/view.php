<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Memo */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Все служебки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Отредактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Сделать pdf и отправить', ['sendmemo', 'id' => $model->id], ['class' => 'btn btn-success']) ?>

</p>

<hr>
<div class="memo-block" style="padding: 10px">

    <div class="memo-head" align="right">
        <?php foreach ($model->recipients as $boss): ?>
            <?= $boss->job ?><br> <?= $boss->name ?><br><br>
        <?php endforeach; ?>
        от <?= $model->user->genitive . ' ' . $model->user->initials ?>
    </div>
    <h3 align="center">СЛУЖЕБНАЯ ЗАПИСКА</h3>

    <table align="left">
        <tr>
            <td>
                Исх №<?= $model->ref_number ?>
            </td>
            <td>
                от <?= !empty($model->customDate) ? $model->customDate : date('"d" M Y', $model->created_at) ?>
            </td>
        </tr>
        <tr>
            <td>
                Касается:
            </td>
            <td>
                <?= $model->title ?>
            </td>
        </tr>

    </table>
    <br>
    <div class="row" style="margin-top: 10px">
        <div class="col-lg-12">
            <article>
                <?= $model->text ?>
            </article>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <?= $model->user->job ?><br>
            <?= $model->user->telephone ?>
        </div>
        <div class="col-lg-8"></div>
        <div class="col-lg-2">
            <?= $model->user->last_name . ' ' . $model->user->initials ?>
        </div>
    </div>
</div>
<hr>
<?= Html::a('Удалить', ['delete', 'id' => $model->id], [
    'class' => 'btn btn-danger',
    'data' => [
        'confirm' => 'Действительно удалить эту служебку?',
        'method' => 'post',
    ],
]) ?>

