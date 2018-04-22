<?php
use yii\widgets\ActiveForm;
use yii\bootstrap\Html;
use kartik\file\FileInput;
use yii\helpers\Url;
?>


<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'userFile[]')->widget(FileInput::classname(), [
    'options' => ['multiple' => true],
]); ?>


<?php ActiveForm::end(); ?>
