<?php

namespace app\modules\admin\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Value]].
 *
 * @see Value
 */
class ValueQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Value[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Value|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param array $category_id
     * @param bool $is_array
     * @return Value[]|array
     */
    public function getFeaturesByCategory($category_id, $is_array = false)
    {
        return $this->select(['feature_id', 'product_id', 'value'])
            ->joinWith(['feature','product'])
            ->where([Product::tableName() . '.category_id' => $category_id])
            ->groupBy(['value'])
            ->asArray($is_array)
            ->all();
    }
}
