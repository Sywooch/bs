<?php

/* @var $this yii\web\View */

use app\models\Product;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="bg-grey">
    <h3><?= Yii::t('app', 'List')?></h3>

    <?php try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'header' => '&nbsp;&#8470;',
                    'headerOptions' => ['width' => '10%', 'class' => 'head-th'],
                    'contentOptions' => ['class' => 'text-center'],
                ],

                [
                    'attribute' => 'title',
                    'headerOptions' => ['width' => '25%', 'class' => 'head-th'],
                ],
                [
                    'attribute' => 'category_id',
                    'headerOptions' => ['width' => '25%', 'class' => 'head-th'],
                    'value' => function (Product $product) {
                        return $product->category->parent->title . ' - ' . $product->category->title;
                    }
                ],
                [
                    'label' => Yii::t('app', 'Tags'),
                    'headerOptions' => ['width' => '20%', 'class' => 'head-th'],
                    'attribute' => 'tag_id',
                    'value' => function (Product $product) {
                        return implode(', ', ArrayHelper::map($product->tags, 'id', 'title'));
                    }
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