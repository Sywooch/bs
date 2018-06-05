<?php

use app\modules\admin\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Category */
/* @var $form yii\widgets\ActiveForm */

$priority_arr = [];
for ($i = -128; $i < 128; $i++) {
    $priority_arr[$i] = $i;
}
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "{label}{error}\n{input}",
    ],
]); ?>

<?= $form->field($model, 'parent_id')->dropDownList(Category::find()->getParentCategories(), ['prompt' => '-']) ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'priority')->dropDownList($priority_arr) ?>

<?= $form->field($model, 'status', ['options' => ['class' => 'form-group i-border']])
    ->checkbox(['label' => Yii::t('app', 'Activate')]) ?>

<?= $form->field($model, 'version')->label(false)->hiddenInput(['value' => $model->version]); ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'),
        ['class' => 'btn btn-site', 'name' => 'sent', 'value' => 'was']) ?>
</div>

<?php ActiveForm::end(); ?>