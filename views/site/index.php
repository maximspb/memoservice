<?php

/* @var $this yii\web\View */

$this->title = 'Система создания служебок v 0.1.0';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Служебки</h1>

    </div>

    <div class="guide-block">
        <hr size="60%" width="2">
        <?php if (Yii::$app->user->can('manageUsers')) : ?>
        <h4>Информация по разделам</h4>
        <article>
            В разделе "Служебки" - для админа отображается список
            всех служебок от всех пользователей. Там же - создание новой служебки,
            редактирование или удаление сохраненных. Для редактирования или удаления
            нужно нажимать кнопки справа от названия служебки:
            <figure class="guide">
            <img src="/pics/tutorial/buttons.jpg"><br>
                <figcaption>
                Это, соответственно, просмотр, редактирование и удаление.
                </figcaption>
            </figure>
        </article>
        <?php endif; ?>
    </div>
</div>
