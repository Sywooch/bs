<?php

namespace app\modules\admin\models;

use app\models\CustomActiveRecord;
use app\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%orders}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $quantity
 * @property string $sum
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 *
 * @property OrderItem[] $orderItems
 * @property User $user
 */
class Order extends CustomActiveRecord
{
    public $order_status = array(
        10 => 'Новый',
        11 => 'В обработке',
        12 => 'Ожидает оплаты',
        13 => 'Оплачен',
        14 => 'Передан в службу доставки',
        15 => 'Выполнен',
        16 => 'Отменен',
    );

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%orders}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'quantity', 'sum'], 'required'],
            [['user_id', 'quantity', 'sum', 'created_at', 'updated_at', 'status'], 'integer'],
            [['sum'], 'number'],
            [['sum'], 'setSum'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'quantity' => Yii::t('app', 'Quantity'),
            'sum' => Yii::t('app', 'Sum'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
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
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderQuery(get_called_class());
    }

    /**
     * @param $cart_total
     * @return bool
     */
    public function saveOrder($cart_total)
    {
        $this->loadDefaultValues();
        $this->user_id = Yii::$app->user->id;
        $this->quantity = $cart_total['qty'];
        $this->sum = $cart_total['sum'] * 100;

        return $this->save();
    }
}
