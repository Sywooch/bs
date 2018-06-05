<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Tag */

$this->title = Yii::t('app', '{modelClass}: {nameAttribute} / {actionName}', [
    'modelClass' => Yii::t('app', 'Tag'),
    'nameAttribute' => $model->title,
    'actionName' => Yii::t('app', 'Edit'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<div class="tag-update bg-grey">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>