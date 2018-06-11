<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'Register User');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="register bg-grey">
    <div class="container">
        <h2><?= Html::encode($this->title) ?></h2>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>