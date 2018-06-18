<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\FeedbackForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Обратная связь';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="contact">
    <h3><?= Html::encode($this->title) ?></h3>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <p>Спасибо за обращение. Мы ответим Вам в ближайшее время.</p>

    <?php else: ?>

        <p>Пожалуйста, свяжитесь с нами для обсуждения вопросов и вариантов покупки.</p>
        <div>
            <?php $form = ActiveForm::begin([
                'id' => 'contact-form',
            ]); ?>

            <?= $form->field($model, 'name', ['options' => ['class' => 'form-group contact-field']])
                ->textInput(['autofocus' => true, 'placeholder' => $model->getAttributeLabel('name')])
                ->label(false) ?>

            <?= $form->field($model, 'surname', ['options' => ['class' => 'form-group contact-field']])
                ->textInput(['placeholder' => $model->getAttributeLabel('surname')])
                ->label(false) ?>

            <?= $form->field($model, 'email')
                ->textInput(['placeholder' => $model->getAttributeLabel('email')])
                ->label(false) ?>

            <?= $form->field($model, 'subject')
                ->textInput(['placeholder' => $model->getAttributeLabel('subject')])
                ->label(false) ?>

            <?= $form->field($model, 'body')->textarea(['rows' => 6, 'placeholder' => $model->getAttributeLabel('body')])
                ->label(false) ?>

            <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => $model->getAttributeLabel('verifyCode'),
                ],
            ])->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    <?php endif; ?>
</div>
