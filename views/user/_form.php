<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'id' => 'register-form',
    'options' => [
        'class' => 'col-md-6 col-sm-9',
    ],
    'fieldConfig' => [
        'template' => "{label}{error}\n{input}",
//                'template' => "{label}\n{beginWrapper}\n{input}\n{error}\n{endWrapper}",
    ],
]); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true, 'autofocus' => true]) ?>

<?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true]) // ['enableAjaxValidation' => true] ?>

<?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

<?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

<?php //echo $form->field($model, 'role')->textInput() ?>
<?php //echo $form->field($model, 'blocked_at')->textInput(['maxlength' => true, 'disabled' => 'true']) ?>

<?= $form->field($model, 'status')->label(false)->hiddenInput() ?>

<?= $form->field($model, 'version')->label(false)->hiddenInput() ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'RegisterBtn') :
        Yii::t('app', 'Save'), ['class' => 'btn btn-site']) ?>
</div>

<?php ActiveForm::end(); ?>