<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
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
<?php
$banner = 'banner-adm';
if (Yii::$app->controller->id === 'admin' && Yii::$app->controller->action->id === 'index') {
    $banner = 'banner-bg2';
}
?>

<div class="banner-bg banner-adm <?= $banner ?>">
    <?= $this->render('menu.php')?>

    <?php try {
        echo Breadcrumbs::widget([
            'homeLink' => [
                'label' => Yii::t('yii', 'Home'),
                'url' => Url::toRoute(['admin/index'])
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]);
    } catch (Exception $e) {
        echo '>>>' . $e->getMessage();
    } ?>
</div>
<!--/banner-->


<div class="wrap">
    <!--    <div class="container">-->
    <?= Alert::widget() ?>
    <?= $content ?>
    <!--    </div>-->
</div>

<footer class="footer">
    <div class="container wrap">
        <div class="logo2">
            <a href="index.php"><img src="images/logo_2.png" alt=""/></a>
            <div class="mt-3"><small>&copy; <?= date('Y') ?></small></div>
            <div class="thin"><small>Интернет-магазин<br>велосипедов</small></div>
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
