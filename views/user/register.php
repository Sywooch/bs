<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'Register User');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="register bg-grey">
    <div class="container">
        <h2 class="my-4"><?= Html::encode($this->title) ?></h2>

        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'options' => [
                'class' => 'col-sm-6 mb-5',
            ],
            'fieldConfig' => [
//                'template' => "{label}\n{beginWrapper}\n{input}\n{error}\n{endWrapper}",
                'template' => "{label}{error}\n{input}",
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

        <?= $form->field($model, 'status')->label(false)->hiddenInput(['value' => 1]);
//            ->hiddenInput(['value' => empty($model->status) ? 1 : $model->status]);
        ?>

        <?= $form->field($model, 'version')->label(false)->hiddenInput(['value' => 1]);
//            ->hiddenInput(['value' => empty($model->version) ? 1 : $model->version + 1]);
        ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'RegisterBtn'),
                ['class' => 'btn btn-site mt-3', 'name' => 'sent', 'value' => 'was', 'id' => 'test']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>