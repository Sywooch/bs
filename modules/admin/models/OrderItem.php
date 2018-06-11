<?php

namespace app\modules\admin\models;

use app\models\CustomActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%order_items}}".
 *
 * @property string $id
 * @property string $order_id
 * @property string $product_id
 * @property string $price
 * @property string $quantity
 * @property string $sum
 *
 * @property Product $product
 * @property Order $order
 */
class OrderItem extends CustomActiveRecord
{
    private $data4insert = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order_items}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'price', 'quantity', 'sum'], 'required'],
            [['order_id', 'product_id', 'price', 'quantity', 'sum'], 'integer'],
            [['price', 'sum'], 'number'],
            [['price'], 'setPrice'],
            [['sum'], 'setSum'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'product_id' => Yii::t('app', 'Product'),
            'price' => Yii::t('app', 'Price'),
            'quantity' => Yii::t('app', 'Quantity'),
            'sum' => Yii::t('app', 'Sum'),
        ];
    }

    /**
     * @return float|int
     */
    public function getPrice()
    {
        return $this->price/100;
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function setPrice($attribute, $params)
    {
        $this->price = $this->price * 100;
    }

    /**
     * @return float|int
     */
    public function getSum()
    {
        return $this->sum/100;
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function setSum($attribute, $params)
    {
        $this->sum = $this->sum * 100;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    /**
     * {@inheritdoc}
     * @return OrderItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderItemQuery(get_called_class());
    }

    /**
     * @throws \yii\db\Exception
     */
    private function storeItems()
    {
        if (!empty($this->data4insert)) {
            $db = Yii::$app->db;
            $sql = $db->createCommand()
                ->batchInsert(OrderItem::tableName(), [
                    'order_id',
                    'product_id',
                    'price',
                    'quantity',
                    'sum'
                ], $this->data4insert);

            $transaction = $db->beginTransaction();
            try {
                $sql->execute();
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->addFlash('error', $e->getMessage());

                return false;
            }
        }
        return true;
    }

    /**
     *
     */
    private function setData4insert()
    {
        $this->data4insert[] = [
            $this->order_id,
            $this->product_id,
            $this->price,
            $this->quantity,
            $this->sum
        ];
    }

    /**
     * @param $cart
     * @param $order_id
     * @return bool
     * @throws \yii\db\Exception
     */
    public function saveOrderItems($cart, $order_id)
    {
        foreach ($cart as $key => $value) {
            $this->order_id = $order_id;
            $this->product_id = $key;
            $this->price = $value['price'] * 100;
            $this->quantity = $value['qty'];
            $this->sum = $value['price'] * $value['qty'] * 100;

            if (!$this->validate()) break;

            $this->setData4insert();
        }

        if ($this->hasErrors()) {
            return false;
        }

        return $this->storeItems();
    }
}
