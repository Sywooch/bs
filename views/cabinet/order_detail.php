<?php

use app\modules\admin\models\OrderItem;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider yii\data\ActiveDataProvider */

?>

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
                'attribute' => 'product_id',
//                'headerOptions' => ['width' => '20%', 'class' => 'head-th'],
                'headerOptions' => ['class' => 'head-th'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function (OrderItem $order_item) {
                    return
//                        $order_item->product->category->parent->title . '<br>' .
//                        $order_item->product->category->title . '<br>' .
                        Html::a($order_item->product->title, Url::toRoute(['product/view', 'id' => $order_item->product_id]));
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'price',
                'headerOptions' => ['width' => '15%', 'class' => 'head-th'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function (OrderItem $order_item) {
                    return $order_item->getPrice();
                },
                'format' => 'currency',
            ],
            [
                'attribute' => 'quantity',
                'headerOptions' => ['width' => '15%', 'class' => 'head-th'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'sum',
                'headerOptions' => ['width' => '15%', 'class' => 'head-th'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function (OrderItem $order_item) {
                    return $order_item->getSum();
                },
                'format' => 'currency',
            ],
        ],
    ]);
} catch (Exception $e) {
    echo Yii::t('app', '{nameAttribute}: {message}', [
        'nameAttribute' => Yii::t('yii', 'Error'),
        'message' => $e->getMessage(),
    ]);
} ?>
