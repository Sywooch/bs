<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \app\models\Filter */
/* @var $category string */
/* @var $features array */
/* @var $sub_categories array */
/* @var $tags array */
/* @var $arr_url array */

$this->title = $category;
$this->params['breadcrumbs'][] = $this->title;

$img_path = Yii::$app->params['product_images'] . DIRECTORY_SEPARATOR;

$data = $dataProvider->getModels();

$page_size = $dataProvider->getPagination()->pageSize;
$column = 4;
$row = $page_size/$column;
?>

<div class="parts">
    <div class="container">
        <h2><?= Html::encode($this->title) ?></h2>
        <div class="bike-parts-sec">
            <div class="bike-parts acces">
                <div class="bike-apparels">
                <?php for ($i = 0; $i < $row; $i++): ?>
                    <div class="parts1">
                    <?php for ($j = 0; $j < $column; $j++): ?>
                        <?php $key = $column * $i + $j ?>
                        <?php if (isset($data[$key])): ?>
                            <a href="<?= Url::toRoute(['product/view', 'id' => $data[$key]['id']]) ?>">
                                <div class="part-sec">
                                    <img src="<?= $img_path . $data[$key]['images'][0]['image'] ?>" alt="Image"/>
                                    <div class="part-info">
                                        <h5><?= $data[$key]['title'] ?><span><?= Yii::$app->formatter->asCurrency($data[$key]['price']/100) ?></span></h5>
                                        <a class="add-cart" href="<?= Url::toRoute(['product/view', 'id' => $data[$key]['id']]) ?>"><?= Yii::t('app', 'Quick View') ?></a>
                                        <a class="qck" href="<?= Url::toRoute(['product/view', 'id' => $data[$key]['id']]) ?>"><?= Yii::t('app', 'Buy') ?></a>
                                    </div>
                                </div>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                        <div class="clearfix"></div>
                    </div>
                <?php endfor; ?>
                </div>

                <div class="text-center mt-5">
                    <?php try {
                        echo LinkPager::widget([
                            'pagination' => $dataProvider->getPagination(),
                            'firstPageLabel' => Yii::t('app', 'First Page'),
                            'lastPageLabel' => Yii::t('app', 'Last Page')
                        ]);
                    } catch (Exception $e) {
                        echo Yii::t('app', '{nameAttribute}: {message}', [
                            'nameAttribute' => Yii::t('yii', 'Error'),
                            'message' => $e->getMessage(),
                        ]);
                    } ?>
                </div>
            </div>

            <div class="rsidebar span_1_of_left">
                <?php $form = ActiveForm::begin([
                    'action' => Url::toRoute([$arr_url['r'], $arr_url['p'] => $arr_url['id']]),
                    'method' => 'GET',
                    'fieldConfig' => [
                        'template' => "<h4>{label}</h4><div class='row row1 scroll-pane'><div class='col col-4'>{input}</div></div>",
                        'options' => [
                            'tag' => 'section',
                            'class' => 'sky-form'
                        ],
                    ]
                ]); ?>

                <?= $form->field($model, 'sub_categories')->checkboxList($sub_categories, [
                    'tag' => false,
                    'item' => function ($index, $label, $name, $checked, $value) {
                        $check = $checked ? 'checked' : null;
                        return "<label class='checkbox'><input type='checkbox' {$check} name='{$name}' value='{$value}'><i></i>{$label}</label>";
                    },
                ]) ?>

                <?= $form->field($model, 'tags')->checkboxList($tags, [
                    'tag' => false,
                    'item' => function ($index, $label, $name, $checked, $value) {
                        $check = $checked ? 'checked' : null;
                        return "<label class='checkbox'><input type='checkbox' {$check} name='{$name}' value='{$value}'><i></i>{$label}</label>";
                    },
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Apply Filter'),
                        ['class' => 'btn btn-site mx-4']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>