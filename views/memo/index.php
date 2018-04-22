<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\MemoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Все служебки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать служебку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'user.last_name',
            'title',
            'created_at:datetime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
