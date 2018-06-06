<?php

/* @var $this yii\web\View */

use app\modules\admin\models\Category;
use yii\helpers\Url;

$this->title = Yii::$app->params['site_name'];

$bike_list = Category::find()->getSubCategories(1);
?>

<div class="caption">
    <div class="slider">
        <div class="callbacks_container">
            <ul class="rslides" id="slider">
                <?php foreach ($bike_list as $bike): ?>
                    <li><h1><?= $bike ?></h1></li>
                <?php endforeach; ?>
            </ul>
            <p>Мы <span>предлагаем</span> то, что поможет <span>осуществить</span> Ваше <span>путешествие</span></p>
            <a class="morebtn" href="<?= Url::toRoute(['product/popular', 'parent_id' => 1, 'tag_id' => 2]) ?>">КУПИТЬ</a>
        </div>
    </div>
</div>