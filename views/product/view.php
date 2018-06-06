<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */

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
            <div class="btn_form">
                <a href="cart.html" class="btn btn-site"><?= Yii::t('app', 'Buy') ?></a>
                <a href="cart.html" class="btn btn-site"><?= Yii::t('app', 'Add To Cart') ?></a>
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