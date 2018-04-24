<?php
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
?>
<?php $form = ActiveForm::begin()
?>
<?= $form->field($model, 'signFile')->fileInput()->label('Выбрать файл изображения в формате png для загрузки:')  ?>
    <button>Загрузить изображение</button>
<?php ActiveForm::end() ?>