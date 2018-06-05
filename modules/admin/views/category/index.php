<?php

use app\modules\admin\models\Category;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="category-index bg-grey">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p><?= Html::a(Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-site']) ?></p>

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
                        'attribute' => 'title',
//                        'contentOptions' => function ($data) {
//                            return $data->parent_id ? ['class' => 'pl-5'] : [];
//                        },
                    ],
                    [
                        'attribute' => 'parent_id',
                        'headerOptions' => ['width' => '20%', 'class' => 'head-th'],
                        'filter' => Category::find()->getParentCategories(),
                        'value' => 'parent.title'
//                        'value' => function (Category $category) {
////                            return $category->parent ? $category->parent->title : null;
//                            return ArrayHelper::getValue($category, 'parent.title');
//                        }
                    ],
                    [
                        'attribute' => 'priority',
                        'filter' => false,
                        'headerOptions' => ['width' => '10%', 'class' => 'head-th'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'status',
                        'headerOptions' => ['width' => '12%', 'class' => 'head-th'],
                        'contentOptions' => ['class' => 'text-center'],
                        'filter' => [
                            Category::STATUS_ACTIVE => Yii::t('app', 'Active'),
                            Category::STATUS_NOT_ACTIVE => Yii::t('app', 'Inactive'),
                        ],
                        'value' => function ($data) {
                            return $data->status == Category::STATUS_ACTIVE ?
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
            echo Yii::t('app', '{nameAttribute}: {message}', [
                'nameAttribute' => Yii::t('yii', 'Error'),
                'message' => $e->getMessage(),
            ]);
        } ?>
    </div>
</div>