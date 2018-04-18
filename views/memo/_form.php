<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use dosamigos\tinymce\TinyMce;


/* @var $this yii\web\View */
/* @var $model app\models\Memo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="memo-form">


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'recipientsList[]')->widget(Select2::class, [
        'data' => $recipients,
        'language' => 'ru',
        'options' => ['placeholder' => 'Кому'],
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true
        ],
    ]); ?>
    <?= $form->field($model, 'customDate')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Выберите дату'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd-M-yyyy',
        ],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(TinyMce::className(), [
        'options' => ['rows' => 6],
        'language' => 'ru',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]); ?>
    <?= $form->field($model, 'ref_number')->textInput(['value' => $model->ref_number]) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
