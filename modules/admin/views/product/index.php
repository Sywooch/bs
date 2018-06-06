<?php

use app\models\CustomActiveRecord;
use app\modules\admin\models\Category;
use app\modules\admin\models\Product;
use app\modules\admin\models\Tag;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;

$category_list = ArrayHelper::map(Category::find()->getAllCategories(), 'id', 'title', 'parent.title');
$tags_list = Tag::find()->getListTags();
?>

<div class="product-index bg-grey">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p><?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-site']) ?></p>

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
                        'headerOptions' => ['width' => '25%', 'class' => 'head-th'],
                    ],
                    [
                        'attribute' => 'category_id',
                        'headerOptions' => ['width' => '25%', 'class' => 'head-th'],
                        'filter' => $category_list,
//                        'value' => 'category.title',
                        'value' => function (Product $product) {
                            return $product->category->parent->title . ' - ' . $product->category->title;
                        }
                    ],
                    [
                        'label' => Yii::t('app', 'Tags'),
                        'headerOptions' => ['width' => '20%', 'class' => 'head-th'],
                        'attribute' => 'tag_id',
//                        'filter' => Tag::find()->getListTags(),
                        'filter' => $tags_list,
                        'value' => function (Product $product) {
                            return implode(', ', ArrayHelper::map($product->tags, 'id', 'title'));
                        }
                    ],
                    [
                        'attribute' => 'price',
                        'value' => 'sum',
//                        'format' => ['currency'],
                        'format' => ['decimal'],
                    ],
                    'discount',
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
            echo Yii::t('app', '{nameAttribute}: {message}', [
                'nameAttribute' => Yii::t('yii', 'Error'),
                'message' => $e->getMessage(),
            ]);
        } ?>
    </div>
</div>
