<?php

/* @var $this \yii\web\View */

use app\models\User;
use yii\helpers\Url;

?>

<div class="container">
    <div class="header">
        <div class="logo">
            <a href="index.php"><img src="images/logo.png" alt=""/></a>
        </div>
        <div class="top-nav">
            <label class="mobile_menu" for="mobile_menu">
                <span>Menu</span>
            </label>
            <input id="mobile_menu" type="checkbox">
            <ul class="nav">
                <li class="dropdown1"><a href="bicycles.html">ВЕЛОСИПЕДЫ</a>
                    <ul class="dropdown2">
                        <li><a href="bicycles.html">ГОРОДСКИЕ</a></li>
                        <li><a href="bicycles.html">ШОССЕЙНЫЕ</a></li>
                        <li><a href="bicycles.html">ГОРНЫЕ</a></li>
                        <li><a href="bicycles.html">ПРЕМИУМ</a></li>
                    </ul>
                </li>
                <li class="dropdown1"><a href="parts.html">ЗАПЧАСТИ</a>
                    <ul class="dropdown2">
                        <li><a href="parts.html">КАМЕРЫ</a></li>
                        <li><a href="parts.html">ШИНЫ</a></li>
                        <li><a href="parts.html">ТОРМОЗА</a></li>
                        <li><a href="parts.html">ЦЕПИ</a></li>
                    </ul>
                </li>
                <li class="dropdown1"><a href="accessories.html">АКСЕССУАРЫ</a>
                    <ul class="dropdown2">
                        <li><a href="accessories.html">ШЛЕМЫ</a></li>
                        <li><a href="accessories.html">ЗАЩИТА</a></li>
                        <li><a href="accessories.html">ЗАМКИ</a></li>
                        <li><a href="accessories.html">jerseys</a></li>
                    </ul>
                </li>
                <li class="dropdown1"><a href="<?= Url::to(['site/about']) ?>">ИНФОРМАЦИЯ</a>
                    <ul class="dropdown2">
                        <li><a href="<?= Url::to(['site/about']) ?>">О НАС</a></li>
                        <li><a href="<?= Url::to(['site/contacts']) ?>">КОНТАКТЫ</a></li>
                        <li><a href="<?= Url::to(['site/feedback']) ?>">ОБРАТНАЯ СВЯЗЬ</a></li>
                    </ul>
                </li>
                <li class="dropdown1">
                    <a href="<?= Yii::$app->user->isGuest ? Url::to(['site/login']) : Url::to(['user/cabinet']) ?>" title="ПОЛЬЗОВАТЕЛЬ">Пользователь</a>
                    <ul class="dropdown2">
                        <?php if (Yii::$app->user->isGuest): ?>
                            <li><a href="<?= Url::to(['site/login']) ?>">ВХОД</a></li>
                            <li><a href="<?= Url::to(['user/register']) ?>">РЕГИСТРАЦИЯ</a></li>
                        <?php else: ?>
                            <?php if (Yii::$app->session->get('user.role') == User::USER_ADMIN) : ?>
                                <li><a href="<?= Url::to(['user/cabinet']) ?>">АДМИН-ЗОНА</a></li>
                            <?php endif; ?>
                            <li><a href="<?= Url::to(['user/cabinet']) ?>">ЛИЧНЫЙ КАБИНЕТ</a></li>
                            <li><a href="<?= Url::to(['site/logout']) ?>" data-method="post">ВЫХОД</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <!--                    <a class="shop" href="cart.html" title="Корзина"><h4><span class="glyphicon glyphicon-shopping-cart"></span></h4></a>-->
                <a class="shop" href="cart.html" title="КОРЗИНА"><img src="images/cart.png" alt="Корзина"/></a>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!--
<script>
    (function ($) {
        $('.dropdown1').on('focus', function (e) {
            console.log('y');
        })
    })(jQuery);
</script>
-->