<?php

use app\models\CustomActiveRecord;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */

$this->title = Yii::t('app', '{modelClass}: {nameAttribute}', [
    'modelClass' => Yii::t('app', 'Product'),
    'nameAttribute' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;

if (empty($model->images)) {
    $image = '-';
} else {
    $image = '';
    $images = ArrayHelper::map($model->images, 'id', 'image');
    foreach ($images as $item) {
        $file = Yii::$app->params['product_images'] . DIRECTORY_SEPARATOR . $item;
//        $image .= Yii::$app->formatter->asImage($file, ['alt' => 'Image', 'class' => 'image-td']);
        $image .= Html::img($file, ['alt' => 'Image', 'class' => 'image-td']);
    }
}
?>

<div class="product-view bg-grey">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-site']) ?>
            <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id], [
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
                    'id',
                    'title',
                    [
                        'attribute' => 'category_id',
                        'value' => ArrayHelper::getValue($model, 'category.parent.title') .
                            ' - ' . ArrayHelper::getValue($model, 'category.title')
                    ],
                    'description:ntext',
                    [
                        'label' => Yii::t('app', 'Image'),
                        'value' => $image,
                        'format' => 'raw',
                    ],
                    [
                        'label' => Yii::t('app', 'Tags'),
                        'value' => implode(', ', ArrayHelper::map($model->tags, 'id', 'title')),
                    ],
                    [
                        'attribute' => 'price',
                        'value' => $model->getSum(),
//                        'format' => ['currency'],
                        'format' => ['decimal'],
                    ],
                    'discount',
                    [
                        'attribute' => 'created_at',
                        'format' => ['datetime'],
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => ['datetime'],
                    ],
                    [
                        'attribute' => 'status',
                        'value' => $model->status == CustomActiveRecord::STATUS_ACTIVE ?
                            '<span class="text-success">' . Yii::t('app', 'Active') . '</span>' :
                            '<span class="text-danger">' . Yii::t('app', 'Inactive') . '</span>',
                        'format' => 'html',
                    ],
                    'version',
                ],
            ]);
        } catch (Exception $e) {
            echo Yii::t('app', '{nameAttribute}: {message}', [
                'nameAttribute' => Yii::t('yii', 'Error'),
                'message' => $e->getMessage(),
            ]);
        } ?>

        <hr>

        <p><?= Html::a(Yii::t('app', 'Add Feature'),
            ['value/create', 'product_id' => $model->id], ['class' => 'btn btn-site']) ?></p>

        <?php try {
            echo GridView::widget([
                'dataProvider' => new ActiveDataProvider(['query' => $model->getValues()->with(['feature'])]),
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => '&nbsp;&#8470;',
                        'headerOptions' => ['width' => '10%', 'class' => 'head-th'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],

                    [
                        'attribute' => 'feature_id',
                        'headerOptions' => ['width' => '25%', 'class' => 'head-th'],
                        'value' => 'feature.title'
                    ],
                    'value',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'controller' => 'value',
                    ],
                ],
            ]);
        } catch (Exception $e) {
            echo Yii::t('app', '{nameAttribute}: {message}', [
                'nameAttribute' => Yii::t('yii', 'Error'),
                'message' => $e->getMessage(),
            ]);
        } ?>
    </div>
</div>