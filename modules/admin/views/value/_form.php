<?php

use app\modules\admin\models\Feature;
use app\modules\admin\models\Product;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Value */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "{label}{error}\n{input}",
    ],
]); ?>

<?= $form->field($model, 'product_id')->dropDownList(Product::find()->getListProducts(), ['prompt' => '-']) ?>

<?= $form->field($model, 'feature_id')->dropDownList(Feature::find()->getListFeatures(), ['prompt' => '-']) ?>

<?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'),
        ['class' => 'btn btn-site', 'name' => 'sent', 'value' => 'was']) ?>
</div>

<?php ActiveForm::end(); ?>