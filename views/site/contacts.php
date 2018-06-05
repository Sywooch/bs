<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Контакты';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="contacts bg-grey pb-5">
    <div class="container">
        <h2 class="my-4">Контактная информация</h2>
        <h4>Наши телефоны:</h4>
        <ul class="list-group pl-5">
            <li>(050) 505-05-05</li>
            <li>(063) 636-36-36</li>
            <li>(068) 686-86-86</li>
        </ul>
        <h4>Нам можно написать:</h4>
        <ul class="list-group pl-5">
            <li>через <a href="<?= Url::to(['/site/contact']) ?>">форму обратной связи</a>.</li>
            <li>на адрес: <a href="mailto: <?= Yii::$app->params['infoEmail'] ?>"><?= Yii::$app->params['infoEmail'] ?></a></li>
        </ul>
        <h4>Адрес офиса:</h4>
        <ul class="list-group pl-5">
            <li>г. Нью-Васюки, пр. Шахматистов, 4</li>
        </ul>
    </div>
</div>