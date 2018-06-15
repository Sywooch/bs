<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = Yii::t('app', '{modelClass}: {nameAttribute}', [
    'modelClass' => Yii::t('app', 'Product'),
    'nameAttribute' => $model->title,
]);
$this->params['breadcrumbs'][] = $model->title;

if (empty($model->images)) {
    $image = '-';
} else {
    $image = '';
    $images = ArrayHelper::map($model->images, 'id', 'image');
    foreach ($images as $item) {
        $file = Yii::$app->params['product_images'] . DIRECTORY_SEPARATOR . $item;
        $image .= Html::img($file, ['alt' => 'Image', 'class' => 'details-image']);
    }
}

$name = preg_split('/ *\(/', $model->title);

$features = $model->getValues()->with(['feature'])->all();
?>

<div class="product">
    <div class="container">
        <div class="details-image">
            <?= $image ?>
        </div>
        <div class="details-left-info">
            <h3><?= $name[0] ?></h3>
            <h4>Model No: <?= trim($name[1], ')') ?></h4>
            <h4></h4>
            <p><?= Yii::$app->formatter->asCurrency($model->price/100) ?></p>
            <div class="btn_form" data-id="<?= $model->id ?>">
                <button class="btn btn-site buy"><?= Yii::t('app', 'Buy') ?></button>
                <button class="btn btn-site add-cart"><?= Yii::t('app', 'Add To Cart') ?></button>
            </div>

            <div class="bike-type">
                <p><?= Yii::t('app', 'Type') ?>  ::<a href="<?= Url::toRoute(['product/list', 'category_id' => $model->category->id ])?>"><?= $model->category->title ?></a></p>

                <?php foreach ($features as $feature): ?>
                <p><?= $feature->feature->title ?>  ::<a href="<?= Url::toRoute(['product/list', 'value' => $feature->value ])?>"><?= $feature->value ?></a> </p>
                <?php endforeach; ?>
            </div>
            <h5><?= Yii::t('app', 'Description') ?>  ::</h5>
            <p class="desc"><?= Yii::$app->formatter->asNtext($model->description) ?></p>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<script>
    (function ($) {
        $('.buy').on('click', function (e) {
            $('#cart-modal').modal('show');

            $.ajax({
                type: "GET",
                url: '/index.php?r=cart/add',
                data: {
                    id: $(this).parent('.btn_form').data('id'),
                    type: 'buy'
                },
            })
            .done(function (response) {
                $('#cart-modal .modal-body').html(response);
            })
            .fail(function (jqXHR) {
                alert("Request failed:\nОшибка запроса.\n" + jqXHR.responseText);
            });
        });
    })(jQuery);

    (function ($) {
        $('.add-cart').on('click', function (e) {
            $.ajax({
                type: "GET",
                url: '/index.php?r=cart/add',
                data: {
                    id: $(this).parent('.btn_form').data('id'),
                },
            })
            .done(function (response) {
                window.alert('Товар добавлен в корзину');
                if ($.isNumeric(response) && response > 0) {
                    $('span#cart-count').text(response);
                }
            })
            .fail(function (jqXHR) {
                alert("Request failed:\nОшибка запроса.\n" + jqXHR.responseText);
            });
        });
    })(jQuery);
</script>