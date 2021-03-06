<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Bike-shop, bike, shop" />

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <!-- jQuery (Bootstrap's JavaScript plugins) -->
    <!-- Custom Theme files -->
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);
        function hideURLbar(){
            window.scrollTo(0,1);
        }
    </script>
    <!--webfont-->
    <link href='http://fonts.googleapis.com/css?family=Roboto:500,900,100,300,700,400' rel='stylesheet' type='text/css'>
    <!--webfont-->
    <!-- dropdown -->
    <!--js-->
    <!---- start-smoth-scrolling---->
    <script type="text/javascript" src="js/move-top.js"></script>
    <script type="text/javascript" src="js/easing.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event){
                event.preventDefault();
                $('html,body').animate({scrollTop:$(this.hash).offset().top},900);
            });
        });
    </script>
    <!---- start-smoth-scrolling---->
</head>
<body>
<?php $this->beginBody() ?>

<!--banner-->
<script src="js/responsiveslides.js"></script>
<script>
    $(function () {
        $("#slider").responsiveSlides({
            auto: true,
            nav: true,
            speed: 500,
            namespace: "callbacks",
            pager: true,
        });
    });
</script>

<?php
Modal::begin([
    'id' => 'cart-modal',
    'size' => 'modal-lg',
    'header' => '<h3 class="ml-5">' . Yii::t('app', 'Cart') . '</h3>',
]);
Modal::end() ?>

<?php
$banner = 'banner-sec';
if (Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'index') {
    $banner = 'banner-bg1';
}
?>

<div class="banner-bg <?= $banner ?>">
    <?= $this->render('menu.php')?>

    <?php try {
        echo Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]);
    } catch (Exception $e) {
        echo Yii::t('app', '{nameAttribute}: {message}', [
            'nameAttribute' => Yii::t('yii', 'Error'),
            'message' => $e->getMessage(),
        ]);
    } ?>
</div>
<!--/banner-->

<div class="wrap">
    <?php try {
        echo Alert::widget();
    } catch (Exception $e) {
        echo Yii::t('app', '{nameAttribute}: {message}', [
            'nameAttribute' => Yii::t('yii', 'Error'),
            'message' => $e->getMessage(),
        ]);
    } ?>
    <?= $content ?>
</div>

<footer class="footer">
    <div class="container wrap">
        <div class="logo2">
            <a href="index.php"><img src="images/logo_2.png" alt=""/></a>
            <div class="mt-3"><small>&copy; <?= date('Y') ?></small></div>
            <div class="thin"><small>Интернет-магазин<br>велосипедов</small></div>
        </div>

        <div class="ftr-menu">
            <dl>
                <dt>Контактная информация</dt>
                <dd>(050) 505-05-05</dd>
                <dd>(063) 636-36-36</dd>
                <dd>(068) 686-86-86</dd>
                <dd class="mt-2">e-mail: <a href="mailto: <?= Yii::$app->params['infoEmail'] ?>"><?= Yii::$app->params['infoEmail'] ?></a></dd>
                <dd></dd>
            </dl>
        </div>

        <div class="ftr-menu">
            <dl>
                <dt>Клиентам</dt>
                <dd><a href="<?= Url::toRoute(['/cabinet/index'])?>">Вход в личный кабинет</a></dd>
                <dd><a href="<?= Url::toRoute(['/site/payment'])?>">Оплата и доставка</a></dd>
                <dd><a href="<?= Url::toRoute(['/site/warranty'])?>">Гарантия</a></dd>
            </dl>
        </div>

        <div class="ftr-menu">
            <dl>
                <dt>Каталог</dt>
                <dd><a href="<?= Url::toRoute(['product/list', 'parent_id' => 1])?>">Велосипеды</a></dd>
                <dd><a href="<?= Url::toRoute(['product/list', 'parent_id' => 4])?>">Запчасти</a></dd>
                <dd><a href="<?= Url::toRoute(['product/list', 'parent_id' => 17])?>">Аксессуары</a></dd>
            </dl>
        </div>

        <div class="clearfix"></div>
    </div>

</footer>

<div class="footer-bottom">
    <div class="container">
        <p><?= Yii::powered() ?> | Design by <a href="http://w3layouts.com/"> W3layouts</a></p>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
