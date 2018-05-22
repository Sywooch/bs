<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = Html::encode($message);
?>

<div class="error bg-grey">
    <div class="container">
        <div class="error-head">
            <h1><?= $exception->statusCode ?></h1>
            <span>ОШИБКА</span>
            <h2><?= $this->title ?></h2>
            <a href="<?= Yii::$app->homeUrl ?>" class="px-4">На главную</a>
        </div>
    </div>
</div>