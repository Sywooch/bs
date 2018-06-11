<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Product;
use app\modules\admin\models\Order;
use app\modules\admin\models\OrderItem;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class CartController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['checkout'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['checkout'],
                        'roles' => ['@'],
                    ],
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $session = \Yii::$app->session;
        $session->open();

        return $session->has('cart_total') ? $session['cart_total']['qty'] : 0;
    }

    /**
     * @return string
     */
    public function actionView()
    {
        $session = \Yii::$app->session;
        $session->open();

        if (\Yii::$app->request->isAjax) {
            return $this->renderPartial('view', [
                'cart' => $session->get('cart'),
                'cart_total' => $session->get('cart_total'),
            ]);
        } else {
            return $this->render('view', [
                'cart' => $session->get('cart'),
                'cart_total' => $session->get('cart_total'),
            ]);
        }
    }

    /**
     * @param $id
     * @param null $type
     * @return string|false
     */
    public function actionAdd($id, $type = null)
    {
        $result = false;

        do {
            $id = intval($id);
            if (!$id) break;

            $product = Product::findOne($id);
            if (empty($product)) break;

            $cart = new Cart();
            $arr = $cart->addToCart($product);

            if ($type) {
                $result = $this->renderPartial('view', [
                    'cart' => $arr['cart'],
                    'cart_total' => $arr['cart_total'],
                ]);
                break;
            }

            $result = $arr['cart_total']['qty'];

        } while (0);

        return $result;
    }

    /**
     * @param $id
     * @param $qty
     * @return string
     */
    public function actionUpdate($id, $qty)
    {
        $result = false;

        do {
            $id = intval($id);
            if (!$id) break;

            $qty = intval($qty);
            if (!$qty || $qty > 99) break;

            $cart = new Cart();
            $arr = $cart->updateCart($id, $qty);

            $result = $this->renderPartial('view', [
                'cart' => $arr['cart'],
                'cart_total' => $arr['cart_total'],
            ]);

        } while (0);

        return $result;
    }

    /**
     * @param $id
     * @return string
     */
    public function actionRemove($id)
    {
        $result = false;

        do {
            $id = intval($id);
            if (!$id) break;

            $cart = new Cart();
            $arr = $cart->removeFromCart($id);

            $result = $this->renderPartial('view', [
                'cart' => $arr['cart'],
                'cart_total' => $arr['cart_total'],
            ]);

        } while (0);

        return $result;
    }

    /**
     * @throws Exception
     */
    public function actionCheckout()
    {
        do {
            $cart = new Cart();
            $cart_content = $cart->getCart();

            if (empty($cart_content['cart'])) {
                Yii::$app->session->addFlash('warning', Yii::t('app', 'Basket is empty'));
                break;
            }

            $order = new Order();
            $result = $order->saveOrder($cart_content['cart_total']);
            if (!$result) {
                Yii::$app->session->addFlash('error', Yii::t('app', 'Order processing error'));
                break;
            }

            $order_items = new OrderItem();
            $result = $order_items->saveOrderItems($cart_content['cart'], $order->id);
            if (!$result) {
                Yii::$app->session->addFlash('error', Yii::t('app', 'Order processing error'));
                break;
            }

            Yii::$app->session->addFlash('info', Yii::t('app', '{nameAttribute_1}. {nameAttribute_2}.', [
                'nameAttribute_1' => Yii::t('app', 'Order accepted'),
                'nameAttribute_2' => Yii::t('app', 'We will contact you'),
            ]));

            $cart->clearCart();

        } while (0);

        return $this->goHome();
    }
}
