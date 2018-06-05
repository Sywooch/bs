<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Value */

$this->title = Yii::t('app', 'Add Feature');

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Products'),
    'url' => ['product/index']
];
$this->params['breadcrumbs'][] = [
    'label' => $model->product->title,
    'url' => ['product/view', 'id' => $model->product_id]
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="value-create bg-grey">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>