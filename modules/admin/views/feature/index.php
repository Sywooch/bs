<?php

use app\models\CustomActiveRecord;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\FeatureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Features');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="feature-index bg-grey">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p><?= Html::a(Yii::t('app', 'Create Feature'), ['create'], ['class' => 'btn btn-site']) ?></p>

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

                    'title',
                    [
                        'attribute' => 'status',
                        'headerOptions' => ['width' => '12%', 'class' => 'head-th'],
                        'contentOptions' => ['class' => 'text-center'],
                        'filter' => [
                            CustomActiveRecord::STATUS_ACTIVE => Yii::t('app', 'Active'),
                            CustomActiveRecord::STATUS_NOT_ACTIVE => Yii::t('app', 'Inactive'),
                        ],
                        'value' => function ($data) {
                            return $data->status == CustomActiveRecord::STATUS_ACTIVE ?
                                '<span class="text-success glyphicon glyphicon-ok"></span>' :
                                '<span class="text-danger glyphicon glyphicon-remove"></span>';
                        },
                        'format' => 'html',
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