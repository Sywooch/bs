<?php

namespace app\modules\admin\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[TagRelation]].
 *
 * @see TagRelation
 */
class TagRelationQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return TagRelation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TagRelation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param array $category_id
     * @param bool $is_array
     * @return TagRelation[]|array
     */
    public function getTagsByCategory($category_id, $is_array = false)
    {
        return $this->select(['tag_id', 'product_id'])
            ->joinWith(['tag','product'])
            ->where([Product::tableName() . '.category_id' => $category_id])
            ->groupBy(['tag_id'])
            ->asArray($is_array)
            ->all();
    }
}
