<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Value */

$this->title = Yii::t('app', 'Product Feature');

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Products'),
    'url' => ['product/index']
];
$this->params['breadcrumbs'][] = [
    'label' => $model->product->title,
    'url' => ['product/view', 'id' => $model->product_id]
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="value-view bg-grey">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a(Yii::t('yii', 'Update'), ['update', 'product_id' => $model->product_id, 'feature_id' => $model->feature_id], ['class' => 'btn btn-site']) ?>
            <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'product_id' => $model->product_id, 'feature_id' => $model->feature_id], [
                'class' => 'btn btn-site',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?php try {
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'product_id',
                        'value' => ArrayHelper::getValue($model, 'product.title')
                    ],
                    [
                        'attribute' => 'feature_id',
                        'value' => ArrayHelper::getValue($model, 'feature.title')
                    ],
                    'value',
                ],
            ]);
        } catch (Exception $e) {
            echo Yii::t('app', 'Undefined Error');
        } ?>
    </div>
</div>