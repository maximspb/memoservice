<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Memo */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Все служебки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Отредактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Сделать pdf и отправить', ['sendmemo', 'id' => $model->id], ['class' => 'btn btn-light']) ?>
    <?= Html::a('Открыть pdf и сохранить на свой комп', ['getpdf', 'id' => $model->id], ['class' => 'btn btn-light']) ?>
    <?= Html::a('Загрузить дополнительные файлы', ['fileupload', 'id' => $model->id], ['class' => 'btn btn-light']) ?>
</p>

<hr>
<?=  GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'filename',
            'header' => 'Дополнительные файлы'
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'userfile',
            'template' => '{delete}',
        ],

    ],
]);?>
<div class="memo-block" style="padding: 10px">

    <div class="memo-head" align="right">
        <?php foreach ($model->recipients as $boss): ?>
            <?= $boss->job ?><br> <?= $boss->name ?><br><br>
        <?php endforeach; ?>
         <?= $model->user->job_genitive.' '. $model->user->genitive . ' ' . $model->user->initials ?>
    </div>
    <h3 align="center">СЛУЖЕБНАЯ ЗАПИСКА</h3>

    <table align="left">
        <tr>
            <td>
                Исх №<?= $model->ref_number ?>
            </td>
            <td>
                от <?= !empty($model->customDate) ? $model->customDate : Yii::$app->formatter->asDate($model->created_at, 'long'); ?>
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
    <div class="row">
        <div class="col-lg-12">
            <article>
                <?= $model->text ?>
            </article>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-12" align="right">
            <table width="100%">
                <tr>
                    <td>
                        <?= $model->user->job ?><br>
                        <?= $model->user->telephone ?>
                    </td>
                    <td align="right">
                        <?= ('1' == $model->needSign) ?  Html::img('/uploads/' .$model->user->id.'/sign/'. 'sign.png') : '' ?>
                    </td>
                    <td align="center">
                        <?= $model->user->last_name . ' ' . $model->user->initials ?>
                    </td>
                </tr>
            </table>
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

