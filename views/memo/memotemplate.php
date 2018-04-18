<div class="memo-head" align="right">
<?php foreach($model->recipients as $boss): ?>
<?= $boss->job ?><br> <?= $boss->name ?><br><br>
<?php endforeach; ?>
от <?=$model->user->genitive. ' '.$model->user->initials ?>
</div>
<h3 align="center">СЛУЖЕБНАЯ ЗАПИСКА</h3>

<table align="left">
    <tr>
        <td>
            Исх №<?= $model->ref_number ?>
        </td>
        <td>
            от <?= !empty($model->customDate) ? $model->customDate : date('"d" M Y',$model->created_at) ?>
        </td>
    </tr>
    <tr>
        <td>
            Касается:
        </td>
        <td>
            <?=$model->title ?>
        </td>
    </tr>

</table>
<br>
<div class="row">
<div class="col-lg-12">
    <article>
    <?=$model->text ?>
</article>
</div>
</div>
<div class="row">
    <div class="col-lg-2">
        <?=$model->user->job ?><br>
        <?=$model->user->telephone ?>
    </div>
    <div class="col-lg-8" align="right"><img src="/sign/sign.png" alt=""> </div>
    <div class="col-lg-2">
        <?= $model->user->last_name.' '.$model->user->initials ?>
    </div>

</div>
