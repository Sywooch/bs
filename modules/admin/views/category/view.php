<?php

use app\models\CustomActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Category */

$this->title = Yii::t('app', '{modelClass}: {nameAttribute}', [
    'modelClass' => Yii::t('app', 'Category'),
    'nameAttribute' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
?>

<div class="category-view bg-grey">
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
//                'template' => '<tr><th style="width:20%">{label}</th><td>{value}</td></tr>',
                'attributes' => [
                    'id',
                    'title',
                    [
                        'attribute' => 'parent_id',
                        'value' => ArrayHelper::getValue($model, 'parent.title')
                    ],
                    'description',
                    'priority',
                    'created_at:datetime',
                    'updated_at:datetime',
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
    </div>
</div>