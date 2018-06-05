<?php

use app\modules\admin\models\Category;
use app\modules\admin\models\Tag;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */
/* @var $form yii\widgets\ActiveForm */

$category_list = ArrayHelper::map(Category::find()->getAllCategories(), 'id', 'title', 'parent.title');
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "{label}{error}\n{input}",
    ],
]); ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'category_id')->dropDownList($category_list, ['prompt' => '-']) ?>

<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'price')->textInput([
    'maxlength' => true, 'value' => Yii::$app->formatter->asDecimal($model->price/100, 2)]) ?>

<?= $form->field($model, 'discount', [
    'template' => '{label}{error}<div class="input-group"><span class="input-group-addon">%</span>{input}</div>',
]) ?>

<?= $form->field($model, 'img', ['options' => ['class' => 'form-group i-border pb-3']])->fileInput() ?>

<?= $form->field($model, 'tagsArray', ['options' => ['class' => 'form-group i-border']])
    ->checkboxList(Tag::find()->getListTags(), ['class' => 'checkbox-list']) ?>

<?= $form->field($model, 'status', ['options' => ['class' => 'form-group i-border']])
    ->checkbox(['label' => Yii::t('app', 'Activate')]) ?>

<?= $form->field($model, 'version')->label(false)->hiddenInput(['value' => $model->version]); ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'),
        ['class' => 'btn btn-site', 'name' => 'sent', 'value' => 'was']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php //$form->field($model, 'cost')->textInput(['maxlength' => true]) ?>
<?php //$form->field($model, 'count')->textInput(['maxlength' => true]) ?>
<?php //$form->field($model, 'is_hit')->textInput() ?>