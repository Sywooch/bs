<?php

/* @var $this \yii\web\View */

use app\models\User;
use app\modules\admin\models\Category;
use yii\helpers\Url;

$category_list = Category::find()->getParentCategories();
$bike_list = Category::find()->getSubCategories(1);
$part_list = Category::find()->getSubCategories(4);
$accessory_list = Category::find()->getSubCategories(17);
//var_dump($category_list, $bike_list, $part_list, $accessory_list);
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
                <li class="dropdown1"><a href="<?= Url::to(['/site/about']) ?>">ИНФОРМАЦИЯ</a>
                    <ul class="dropdown2">
                        <li><a href="<?= Url::to(['/site/about']) ?>">О НАС</a></li>
                        <li><a href="<?= Url::to(['/site/contacts']) ?>">КОНТАКТЫ</a></li>
                        <li><a href="<?= Url::to(['/site/feedback']) ?>">ОБРАТНАЯ СВЯЗЬ</a></li>
                    </ul>
                </li>
                <li class="dropdown1">
                    <a href="<?= Yii::$app->user->isGuest ? Url::to(['/site/login']) : Url::to(['/user/cabinet']) ?>" title="ПОЛЬЗОВАТЕЛЬ">Пользователь</a>
                    <ul class="dropdown2">
                        <?php if (Yii::$app->user->isGuest): ?>
                            <li><a href="<?= Url::to(['/site/login']) ?>">ВХОД</a></li>
                            <li><a href="<?= Url::to(['/user/register']) ?>">РЕГИСТРАЦИЯ</a></li>
                        <?php else: ?>
                            <?php if (Yii::$app->session->get('user.role') === User::USER_ADMIN) : ?>
                                <li><a href="<?= Url::to(['/admin']) ?>">АДМИН-ЗОНА</a></li>
                            <?php endif; ?>
                            <li><a href="<?= Url::to(['/user/cabinet']) ?>">ЛИЧНЫЙ КАБИНЕТ</a></li>
                            <li><a href="<?= Url::to(['/site/logout']) ?>" data-method="post">ВЫХОД</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <!--                    <a class="shop" href="cart.html" title="Корзина"><h4><span class="glyphicon glyphicon-shopping-cart"></span></h4></a>-->
                <a class="shop" href="cart.html" title="КОРЗИНА"><img src="/images/cart.png" alt="Корзина"/></a>
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