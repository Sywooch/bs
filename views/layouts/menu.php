<?php

/* @var $this \yii\web\View */

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
                <li class="dropdown1"><a href="<?= Url::to(['site/login']) ?>">ВХОД</a>
                    <ul class="dropdown2">
                        <li><a href="<?= Url::to(['user/register']) ?>">РЕГИСТРАЦИЯ</a></li>
                    </ul>
                </li>
                <!--                    <a class="shop" href="cart.html" title="Корзина"><h4><span class="glyphicon glyphicon-shopping-cart"></span></h4></a>-->
                <a class="shop" href="cart.html" title="КОРЗИНА"><img src="images/cart.png" alt="Корзина"/></a>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>