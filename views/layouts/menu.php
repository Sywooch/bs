<?php

/* @var $this \yii\web\View */

use app\models\User;
use app\modules\admin\models\Category;
use yii\helpers\Url;

$category_list = Category::find()->getParentCategories();
$bike_list = Category::find()->getSubCategories(1);
$part_list = Category::find()->getSubCategories(4);
$accessory_list = Category::find()->getSubCategories(17);
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
                <li class="dropdown1">
                    <a href="<?= Url::toRoute(['product/list', 'parent_id' => 1])?>"><?= $category_list[1] ?></a>
                    <ul class="dropdown2">
                        <li><a href="<?= Url::toRoute(['product/popular', 'parent_id' => 1, 'tag_id' => 2])?>"><?= Yii::t('app', 'Popular') ?></a></li>
                        <?php foreach ($bike_list as $id => $value): ?>
                            <li><a href="<?= Url::toRoute(['product/list', 'category_id' => $id])?>"><?= $value ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li class="dropdown1">
                    <a href="<?= Url::toRoute(['product/list', 'parent_id' => 4])?>"><?= $category_list[4] ?></a>
                    <ul class="dropdown2">
                        <li><a href="<?= Url::toRoute(['product/popular', 'parent_id' => 4, 'tag_id' => 2])?>"><?= Yii::t('app', 'Popular') ?></a></li>
                        <?php foreach ($part_list as $id => $value): ?>
                            <li><a href="<?= Url::toRoute(['product/list', 'category_id' => $id])?>"><?= $value ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li class="dropdown1">
                    <a href="<?= Url::toRoute(['product/list', 'parent_id' => 17])?>"><?= $category_list[17] ?></a>
                    <ul class="dropdown2">
                        <li><a href="<?= Url::toRoute(['product/popular', 'parent_id' => 17, 'tag_id' => 2])?>"><?= Yii::t('app', 'Popular') ?></a></li>
                        <?php foreach ($accessory_list as $id => $value): ?>
                            <li><a href="<?= Url::toRoute(['product/list', 'category_id' => $id])?>"><?= $value ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li class="dropdown1"><a href="<?= Url::toRoute(['/site/about']) ?>">ИНФОРМАЦИЯ</a>
                    <ul class="dropdown2">
                        <li><a href="<?= Url::toRoute(['/site/about']) ?>">О НАС</a></li>
                        <li><a href="<?= Url::toRoute(['/site/contacts']) ?>">КОНТАКТЫ</a></li>
                        <li><a href="<?= Url::toRoute(['/site/feedback']) ?>">ОБРАТНАЯ СВЯЗЬ</a></li>
                    </ul>
                </li>
                <li class="dropdown1">
                    <a href="<?= Yii::$app->user->isGuest ? Url::toRoute(['/site/login']) : Url::toRoute(['/cabinet/index']) ?>" title="ПОЛЬЗОВАТЕЛЬ">Пользователь</a>
                    <ul class="dropdown2">
                        <?php if (Yii::$app->user->isGuest): ?>
                            <li><a href="<?= Url::toRoute(['/site/login']) ?>">ВХОД</a></li>
                            <li><a href="<?= Url::toRoute(['/user/create']) ?>">РЕГИСТРАЦИЯ</a></li>
                        <?php else: ?>
                            <?php if (Yii::$app->session->get('user.role') === User::USER_ADMIN) : ?>
                                <li><a href="<?= Url::toRoute(['/admin']) ?>">АДМИН-ЗОНА</a></li>
                            <?php endif; ?>
                            <li><a href="<?= Url::toRoute(['/cabinet/index']) ?>">ЛИЧНЫЙ КАБИНЕТ</a></li>
                            <li><a href="<?= Url::toRoute(['/site/logout']) ?>" data-method="post">ВЫХОД</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <li class="dropdown1 cart-img">
                    <a href="<?= Url::toRoute(['cart/view']) ?>" id="show-cart" class="shop px-5 pb-3" title="КОРЗИНА" data-toggle="modal" data-target="#cart-modal">
                        <img src="/images/cart.png" alt="Корзина"/>
                        <span class="badge" id="cart-count"><?= empty($_SESSION['cart_total']) ? null : $_SESSION['cart_total']['qty'] ?></span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<script>
    (function ($) {
        $('#show-cart').on('click', function (e) {
            e.preventDefault();

            $.ajax({
                type: "GET",
                url: '/index.php?r=cart/view'
            })
            .done(function (response) {
                $('#cart-modal .modal-body').html(response);
            })
            .fail(function (jqXHR) {
                alert("Request failed:\nОшибка запроса.\n" + jqXHR.responseText);
            });
        })
    })(jQuery);

    (function ($) {
        $('#cart-modal').on('hide.bs.modal', function (e) {
            $.ajax({
                type: "GET",
                url: '/index.php?r=cart/index'
            })
            .done(function (response) {
                if ($.isNumeric(response) && response > 0) {
                    $('span#cart-count').text(response);
                } else {
                    $('span#cart-count').empty();
                }
            })
        });
    })(jQuery);
</script>