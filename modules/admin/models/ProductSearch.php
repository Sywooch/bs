<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Product;

/**
 * ProductSearch represents the model behind the search form of `app\modules\admin\models\Product`.
 */
class ProductSearch extends Product
{
    public $tag_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['id', 'category_id', 'price', 'discount', 'cost', 'count', 'is_hit', 'created_at', 'updated_at', 'status', 'version'], 'integer'],
            [['id', 'category_id', 'tag_id', 'price', 'discount', 'status'], 'integer'],
            [['title'], 'safe'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Product::find()->joinWith(['category', 'tagRelations'])->with(['tags', 'images']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['title' => SORT_ASC],
                'attributes' => [
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

        $this->load($params);

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
            TagRelation::tableName() . '.tag_id' => $this->tag_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
