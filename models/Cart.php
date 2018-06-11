<?php

namespace app\models;

use app\modules\admin\models\Image;

class Cart extends CustomActiveRecord
{
    protected $cart = [];

    /**
     * @return array
     */
    public function getCart()
    {
        $session = \Yii::$app->session;
        $session->open();

        $this->cart['cart'] = $session->has('cart') ? $session->get('cart') : array();
        $this->cart['cart_total'] = $session->has('cart_total') ? $session->get('cart_total') : array();

        return $this->cart;
    }

    /**
     *
     */
    public function storeCart()
    {
        $session = \Yii::$app->session;
        $session->open();

        if (empty($this->cart['cart'])) {
            $session->remove('cart');
            $session->remove('cart_total');
        } else {
            $session->set('cart', $this->cart['cart']);
            $session->set('cart_total', $this->cart['cart_total']);
        }
    }

    /**
     * @return array
     */
    public function totalOrder()
    {
        if (!empty($this->cart)) {
            $this->cart['cart_total'] = [
                'qty' => 0,
                'sum' => 0
            ];

            if (!empty($this->cart['cart'])) {
                foreach ($this->cart['cart'] as $item) {
                    $this->cart['cart_total']['qty'] += $item['qty'];
                    $this->cart['cart_total']['sum'] += $item['qty'] * $item['price'];
                }
            }

            $this->storeCart();
        }

        return $this->cart;
    }

    /**
     * @param Product $product
     * @return array
     */
    public function addToCart(Product $product)
    {
        $this->getCart();

        do {
            if (!isset($this->cart['cart'][$product->id])) {
                /* @var $image Image */
                $image = $product->getImages()
                    ->select('image')
                    ->orderBy(['priority' => SORT_DESC])
                    ->limit(1)
                    ->one();

                $this->cart['cart'][$product->id] = [
                    'title' => $product->title,
                    'qty' => 1,
                    'price' => $product->getSum(),
                    'image' => $image->image
                ];
                break;
            }

            if ($this->cart['cart'][$product->id]['qty'] < 99) {
                $this->cart['cart'][$product->id]['qty'] += 1;
            }

        } while (0);

        return $this->totalOrder();
    }

    /**
     * @param $id
     * @param $qty
     * @return array
     */
    public function updateCart($id, $qty)
    {
        $this->getCart();

        if (isset($this->cart['cart'][$id])) {
            $this->cart['cart'][$id]['qty'] = $qty;
        }

        return $this->totalOrder();
    }

    /**
     * @param $id
     * @return array
     */
    public function removeFromCart($id)
    {
        $this->getCart();

        if (isset($this->cart['cart'][$id])) {
            unset($this->cart['cart'][$id]);
        }

        return $this->totalOrder();
    }

    /**
     *
     */
    public function clearCart()
    {
        $session = \Yii::$app->session;
        $session->open();

        $session->remove('cart');
        $session->remove('cart_total');
    }
}