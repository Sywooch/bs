<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $title null|string */
/* @var $page null|string */
/* @var $content null|array */

$this->title = Yii::t('app', 'Personal Area');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bg-grey">
    <div class="container">
        <div class="col-sm-3 my-4">
            <ul>
                <li><a href="<?= Url::toRoute(['/user/update']) ?>"><?= Yii::t('app', 'Personal Data') ?></a></li>
                <li><a href="<?= Url::toRoute(['/cabinet/my-orders']) ?>"><?= Yii::t('app', 'My orders') ?></a></li>
            </ul>
        </div>
        
        <div class="col-sm-9">
            <div class="personal-content">
                <h2><?= Html::encode($title) ?></h2>
                <?php if (!empty($page)): ?>
                    <?= $this->render($page, $content) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>