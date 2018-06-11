<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $category string */

use yii\bootstrap\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', '{modelClass} {nameAttribute}', [
    'modelClass' => Yii::t('app', 'Popular'),
    'nameAttribute' => $category,
]);
$this->params['breadcrumbs'][] = $this->title;

$img_path = Yii::$app->params['product_images'] . DIRECTORY_SEPARATOR;

$data = $dataProvider->getModels();
?>

<div class="bikes">
    <h3><?= Html::encode($this->title) ?></h3>

    <div class="bikes-grids">
        <ul id="flexiselDemo1">
            <?php foreach ($data as $value): ?>
                <li>
                    <img src="<?= $img_path . $value['images'][0]['image'] ?>" alt="Image"/>
                    <div class="bike-info">
                        <div class="model">
                            <h4><?= $value['title'] ?><span><?= Yii::$app->formatter->asCurrency($value['price']/100) ?></span></h4>
                        </div>
                        <div class="model-info">
                            <a href="<?= Url::toRoute(['product/view', 'id' => $value['id']]) ?>" class="btn btn-site"><?= Yii::t('app', 'Buy')?></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="viw">
                        <a href="<?= Url::toRoute(['product/view', 'id' => $value['id']]) ?>"><?= Yii::t('app', 'Quick View')?></a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <script type="text/javascript">
            $(window).on('load', function() {
                $("#flexiselDemo1").flexisel({
                    visibleItems: 3,
                    animationSpeed: 1000,
                    autoPlay: true,
                    // autoPlay: false,
                    autoPlaySpeed: 3000,
                    pauseOnHover:true,
                    enableResponsiveBreakpoints: true,
                    responsiveBreakpoints: {
                        portrait: {
                            changePoint:480,
                            visibleItems: 1
                        },
                        landscape: {
                            changePoint:640,
                            visibleItems: 2
                        },
                        tablet: {
                            changePoint:768,
                            visibleItems: 3
                        }
                    }
                });
            });
        </script>
        <script type="text/javascript" src="js/jquery.flexisel.js"></script>
    </div>
</div>