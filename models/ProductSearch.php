<?php

namespace app\models;

use app\modules\admin\models\Category;
use app\modules\admin\models\TagRelation;
use app\modules\admin\models\Value;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProductSearch represents the model behind the search form of `app\modules\admin\models\Product`.
 */
class ProductSearch extends Product
{
    public $parent_id;
    public $tag_id;
    public $value;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'category_id', 'tag_id', 'price', 'discount', 'status'], 'integer'],
            [['title', 'value'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @param bool $is_array
     * @return ActiveDataProvider
     */
    public function search($params, $is_array = false)
    {
        $query = Product::find()
            ->joinWith(['category', 'tagRelations', 'values'])
            ->with(['tags', 'images'])
            ->groupBy(Value::tableName() . '.product_id')
            ->asArray($is_array);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
                'attributes' => [
                    'id',
                    'title',
                    'price',
                    'active',
                    'category_id' => [
                        'asc' => [Category::tableName() . '.title' => SORT_ASC],
                        'desc' => [Category::tableName() . '.title' => SORT_DESC],
                    ]
                ]
            ],
        ]);

        $this->load(['ProductSearch' => $params]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'discount' => $this->discount,
            'status' => $this->status,
            Category::tableName() . '.parent_id' => $this->parent_id,
            TagRelation::tableName() . '.tag_id' => $this->tag_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', Value::tableName() . '.value', $this->value]);

        return $dataProvider;
    }
}
