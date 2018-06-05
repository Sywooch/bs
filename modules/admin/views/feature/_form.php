<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Feature */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "{label}{error}\n{input}",
    ],
]); ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'status', ['options' => ['class' => 'form-group i-border']])
    ->checkbox(['label' => Yii::t('app', 'Activate')]) ?>

<?= $form->field($model, 'version')->label(false)->hiddenInput(['value' => $model->version]); ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'),
        ['class' => 'btn btn-site', 'name' => 'sent', 'value' => 'was']) ?>
</div>

<?php ActiveForm::end(); ?>