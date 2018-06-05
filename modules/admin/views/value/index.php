<?php

use app\modules\admin\models\Feature;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ValueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Values');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="value-index bg-grey">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p><?= Html::a(Yii::t('app', 'Create Value'), ['create'], ['class' => 'btn btn-site']) ?></p>

        <?php try {
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => '&nbsp;&#8470;',
                        'headerOptions' => ['width' => '10%', 'class' => 'head-th'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],

                    [
                        'attribute' => 'product_id',
                        'headerOptions' => ['width' => '25%', 'class' => 'head-th'],
//                        'filter' => Product::find()->getListProducts(),
                        'value' => 'product.title',
                    ],
                    [
                        'attribute' => 'feature_id',
                        'headerOptions' => ['width' => '25%', 'class' => 'head-th'],
                        'filter' => Feature::find()->getListFeatures(),
                        'value' => 'feature.title'
                    ],
                    [
                        'attribute' => 'value',
                        'headerOptions' => ['width' => '25%', 'class' => 'head-th'],
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => Yii::t('app', 'Action'),
                        'headerOptions' => ['width' => '10%', 'class' => 'head-th'],
                        'template' => '{view} | {update} | {delete}',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                ],
            ]);
        } catch (Exception $e) {
            echo Yii::t('app', 'Undefined Error');
        } ?>
    </div>
</div>