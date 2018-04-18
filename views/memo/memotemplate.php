<div class="memo-head" align="right">
<?php foreach($memo->recipients as $boss): ?>
<?= $boss->job ?><br> <?= $boss->name ?><br><br>
<?php endforeach; ?>
от <?=$memo->user->genitive. ' '.$memo->user->initials ?>
</div>
<h3 align="center">СЛУЖЕБНАЯ ЗАПИСКА</h3>

<table align="left">
    <tr>
        <td>
            Исх №<?=$memo->ref_number ?>
        </td>
        <td>
            от <?=$memo->created_at ?>
        </td>
    </tr>
    <tr>
        <td>
            Касается:
        </td>
        <td>
            <?=$memo->title ?>
        </td>
    </tr>

</table>
<br>
<div class="row">
<div class="col-lg-12">
    <article>
    <?=$memo->text ?>
</article>
</div>
</div>
<div class="row">
    <div class="col-lg-2">
        <?=$memo->user->job ?><br>
        <?=$memo->user->telephone ?>
    </div>
    <div class="col-lg-8">  </div>
    <div class="col-lg-2">
        <?= $memo->user->last_name.' '.$memo->user->initials ?>
    </div>

</div>
