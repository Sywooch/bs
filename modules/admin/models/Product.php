<?php

namespace app\modules\admin\models;

use app\models\CustomActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property string $id
 * @property string $title
 * @property string $category_id
 * @property string $description
 * @property string $price
 * @property int $discount
 * @property string $cost
 * @property string $count
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 * @property string $version
 *
 * @property Image[] $images
 * @property Category $category
 * @property TagRelation[] $tagRelations
 * @property Tag[] $tags
 * @property Value[] $values
 * @property Feature[] $features
 */
class Product extends CustomActiveRecord
{
    public $img;
    private $_tagsArray;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'category_id'], 'required'],
            [['title'], 'filter', 'filter' => 'trim'],
            [['title'], 'string', 'max' => 150],
            [['title'], 'match', 'pattern' => Yii::$app->params['patterns']['alphanum-x']],
            [['title', 'category_id'], 'unique', 'targetAttribute' => ['title', 'category_id']],
            [['price', 'discount', 'cost', 'count'], 'default', 'value' => 0],
            [['category_id', 'discount', 'count', 'created_at', 'updated_at', 'status', 'version'], 'integer'],
//            [['price', 'cost'], 'number', 'numberPattern'=>'[0-9]*\.[0-9]+|[0-9]+'],
            [['price', 'cost'], 'number'],
            [['price'], 'setSum'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['description'], 'string'],
            [['description'], 'match', 'pattern' => Yii::$app->params['patterns']['alphanum-x']],
//            ['tagsArray', 'each', 'rule' => ['integer']],
            [['tagsArray'], 'safe'],
            [['img'], 'safe']
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
            'category_id' => Yii::t('app', 'Category'),
            'description' => Yii::t('app', 'Description'),
            'price' => Yii::t('app', 'Price'),
            'discount' => Yii::t('app', 'Discount'),
            'cost' => Yii::t('app', 'Cost'),
            'count' => Yii::t('app', 'Count'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => Yii::t('app', 'Status'),
            'version' => Yii::t('app', 'Version'),
            'tagsArray' => Yii::t('app', 'Tags'),
            'img' => Yii::t('app', 'Image'),
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
        return $this->price/100;
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function setSum($attribute, $params)
    {
        $this->price = $this->price * 100;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::class, ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagRelations()
    {
        return $this->hasMany(TagRelation::class, ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('{{%tag_relations}}', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(Value::class, ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeatures()
    {
        return $this->hasMany(Feature::class, ['id' => 'feature_id'])
            ->viaTable('{{%values}}', ['product_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    /**
     * @return array
     */
    public function getTagsArray()
    {
        if (empty($this->_tagsArray)) {
            $this->_tagsArray = $this->getTags()->select('id')->column();
        }

        return $this->_tagsArray;
    }

    /**
     * @param $value
     * @return array
     */
    public function setTagsArray($value)
    {
        return $this->_tagsArray = (array) $value;
    }

    /**
     * @return void
     */
    public function updateTags()
    {
        $existing_tags = $this->getTags()->select('id')->column();
        $new_tags = $this->getTagsArray();

        $arr_tags = array_filter(array_diff($new_tags, $existing_tags));
        foreach ($arr_tags as $tag_id) {
            /** @var Tag $tag */
            if ($tag = Tag::findOne($tag_id)) {
                $this->link('tags', $tag);
            }
        }

        $arr_tags = array_filter(array_diff($existing_tags, $new_tags));
        foreach ($arr_tags as $tag_id) {
            /** @var Tag $tag */
            if ($tag = Tag::findOne($tag_id)) {
                $this->unlink('tags', $tag, true);
            }
        }
    }
}
