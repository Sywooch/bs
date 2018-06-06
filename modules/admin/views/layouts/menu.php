<?php

/* @var $this \yii\web\View */

use app\models\User;
use yii\helpers\Url;

?>

<div class="container">
    <div class="header">
        <div class="logo">
            <a href="/index.php"><img src="/images/logo.png" alt=""/></a>
        </div>
        <div class="top-nav">
            <label class="mobile_menu" for="mobile_menu">
                <span>Menu</span>
            </label>
            <input id="mobile_menu" type="checkbox">
            <ul class="nav">
                <li class="dropdown1"><a href="<?= Url::toRoute(['admin/index'])?>">КАТАЛОГ</a>
                    <ul class="dropdown2">
                        <li><a href="<?= Url::toRoute(['category/index'])?>">КАТЕГОРИИ</a></li>
                        <li><a href="<?= Url::toRoute(['product/index'])?>">ТОВАРЫ</a></li>
                        <li><a href="<?= Url::toRoute(['tag/index'])?>">МЕТКИ</a></li>
                        <li><a href="<?= Url::toRoute(['feature/index'])?>">ХАРАКТЕРИСТИКИ</a></li>
                    </ul>
                </li>
                <li class="dropdown1"><a href="parts.html">ПОЛЬЗОВАТЕЛИ</a>
                    <ul class="dropdown2">
                    </ul>
                </li>
                <li class="dropdown1"><a href="<?= Url::to(['/site/logout']) ?>" data-method="post">ВЫХОД</a></li>
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