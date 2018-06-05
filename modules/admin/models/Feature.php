<?php

namespace app\modules\admin\models;

use app\models\CustomActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%features}}".
 *
 * @property string $id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 * @property string $version
 *
 * @property Value[] $values
 */
class Feature extends CustomActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%features}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'filter', 'filter' => 'trim'],
            [['title'], 'string', 'max' => 50],
            [['title'], 'match', 'pattern' => Yii::$app->params['patterns']['alpha-x']],
            [['title'], 'unique'],
            [['created_at', 'updated_at', 'status', 'version'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => Yii::t('app', 'Status'),
            'version' => Yii::t('app', 'Version'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(Value::class, ['feature_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return FeatureQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FeatureQuery(get_called_class());
    }
}
