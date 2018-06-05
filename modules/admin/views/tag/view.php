<?php

use app\models\CustomActiveRecord;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Tag */

$this->title = Yii::t('app', '{modelClass}: {nameAttribute}', [
    'modelClass' => Yii::t('app', 'Tag'),
    'nameAttribute' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;;
?>

<div class="tag-view bg-grey">
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
            echo Yii::t('yii', 'Error');
        } ?>
    </div>
</div>