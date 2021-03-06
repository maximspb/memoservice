<?php

use yii\helpers\Html;
?>

<div class="memo-block">
    <div class="memo-head" align="right">
        <?php foreach ($model->recipients as $boss): ?>
            <?= $boss->job ?><br> <?= $boss->name ?><br><br>
        <?php endforeach; ?>
         <?= $model->user->genitive . ' ' . $model->user->initials ?>
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
                     <?= !empty($model->needSign) ?  Html::img('/uploads/' .$model->user->id.'/sign/'. 'sign.png') : '' ?>
                    </td>
                    <td align="center">
                        <?= $model->user->last_name . ' ' . $model->user->initials ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
