<?php

use app\modules\admin\models\Order;
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
                'attribute' => 'created_at',
                'headerOptions' => ['width' => '25%', 'class' => 'head-th'],
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'date'
            ],
            [
                'attribute' => 'sum',
                'headerOptions' => ['width' => '25%', 'class' => 'head-th'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function (Order $order) {
                    return $order->getSum();
                },
                'format' => 'currency',
            ],
            [
                'attribute' => 'status',
                'headerOptions' => ['width' => '15%', 'class' => 'head-th'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function (Order $order) {
                    return $order->order_status[$order->status];
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '10%', 'class' => 'head-th'],
                'contentOptions' => ['class' => 'text-center'],
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $url = Url::toRoute(['cabinet/order-detail', 'order_id' => $key]);
                        return Html::a('', $url, [
                            'class' => 'glyphicon glyphicon-eye-open',
                            'title' => Yii::t('yii', 'View')
                        ]);
                    },
                ]
            ],
        ],
    ]);
} catch (Exception $e) {
    echo Yii::t('app', '{nameAttribute}: {message}', [
        'nameAttribute' => Yii::t('yii', 'Error'),
        'message' => $e->getMessage(),
    ]);
} ?>
