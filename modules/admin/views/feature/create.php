<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Feature */

$this->title = Yii::t('app', 'Create Feature');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Features'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="feature-create bg-grey">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>