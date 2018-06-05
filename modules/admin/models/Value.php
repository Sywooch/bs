<?php

namespace app\modules\admin\models;

use app\models\CustomActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%values}}".
 *
 * @property string $product_id
 * @property string $feature_id
 * @property string $value
 *
 * @property Feature $feature
 * @property Product $product
 */
class Value extends CustomActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%values}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'feature_id', 'value'], 'required'],
            [['product_id', 'feature_id'], 'integer'],
            [['product_id', 'feature_id'], 'unique', 'targetAttribute' => ['product_id', 'feature_id']],
            [['value'], 'filter', 'filter' => 'trim'],
            [['value'], 'string', 'max' => 255],
            [['value'], 'match', 'pattern' => Yii::$app->params['patterns']['alphanum-x']],
            [['feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => Feature::class, 'targetAttribute' => ['feature_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'Product'),
            'feature_id' => Yii::t('app', 'Feature'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeature()
    {
        return $this->hasOne(Feature::class, ['id' => 'feature_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     * @return ValueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ValueQuery(get_called_class());
    }
}
