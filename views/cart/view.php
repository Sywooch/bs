<?php

/* @var $this yii\web\View */
/* @var $cart array */
/* @var $cart_total array */

use yii\helpers\Url;

?>

<div class="cart">
    <div class="container">
        <?php if (empty($cart)): ?>
        <h3><?= Yii::t('app', 'Basket is empty') ?></h3>
        <?php else: ?>
        <div class="col-md-8 cart-items">
            <?php foreach ($cart as $key => $value): ?>
            <div class="cart-header" data-id="<?= $key ?>">
                <div class="close1"> </div>
                <div class="cart-sec">
                    <div class="cart-item cyc">
                        <img src="<?= Yii::$app->params['product_images'] . DIRECTORY_SEPARATOR . $value['image'] ?>"/>
                    </div>
                    <div class="cart-item-info">
                        <?php $name = preg_split('/ *\(/', $value['title']); ?>
                        <h3><?= $name[0] ?><span>Model No: <?= trim($name[1], ')') ?></span></h3>
                        <h4><?= Yii::$app->formatter->asCurrency($value['price']) ?></h4>
                        <p class="qty">Qty ::</p>
                        <input min="1" max="99" type="number" name="quantity" value="<?= $value['qty'] ?>" class="form-control input-small">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="col-md-4 cart-total">
            <a class="continue" href="<?= Yii::$app->request->referrer ?>" data-dismiss="modal"><?= Yii::t('app', 'Continue to basket') ?></a>
            <div class="price-details">
                <h3><?= Yii::t('app', 'Price Details') ?></h3>
                <span><?= Yii::t('app', 'Total') ?></span>
                <span class="total"><?= $cart_total['qty'] ?></span>
                <span><?= Yii::t('app', 'Total cost') ?></span>
                <span class="total"><?= Yii::$app->formatter->asCurrency($cart_total['sum']) ?></span>
                <span><?= Yii::t('app', 'Discount') ?></span>
                <span class="total">---</span>
                <div class="clearfix"></div>
            </div>
            <h4 class="last-price"><?= Yii::t('app', 'Total') ?></h4>
            <span class="total final"><?= Yii::$app->formatter->asCurrency($cart_total['sum']) ?></span>
            <div class="clearfix"></div>
            <a class="order" href="<?= Url::toRoute(['/cart/checkout']) ?>"><?= Yii::t('app', 'Place Order') ?></a>
        </div>
        <?php endif; ?>
    </div>

    <script>
        (function ($) {
            $('.close1').on('click', function(e) {
                let row = $(this).parent('.cart-header');
                $('.cart-total').fadeOut('slow');

                row.fadeOut('slow', function(e){
                    row.remove();
                });

                $.ajax({
                    type: "GET",
                    url: '/index.php?r=cart/remove',
                    data: {
                        id: row.data('id')
                    },
                })
                .done(function (response) {
                    $('#cart-modal .modal-body').html(response);
                })
                .fail(function (jqXHR) {
                    alert("Request failed:\nОшибка запроса.\n" + jqXHR.responseText);
                });
            });
        })(jQuery);

        (function ($) {
            $('.input-small').on('blur', function (e) {
                let qty = $(this).val();
                $('.cart-total').fadeOut('slow');

                $.ajax({
                    type: "GET",
                    url: '/index.php?r=cart/update',
                    data: {
                        id: $(this).parents('.cart-header').data('id'),
                        qty: qty
                    },
                })
                    .done(function (response) {
                        $('#cart-modal .modal-body').html(response);
                    })
                    .fail(function (jqXHR) {
                        alert("Request failed:\nОшибка запроса.\n" + jqXHR.responseText);
                    });
            })
        })(jQuery);
    </script>
</div>
