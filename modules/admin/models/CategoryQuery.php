<?php

namespace app\modules\admin\models;

use app\models\CustomActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Category]].
 *
 * @see Category
 */
class CategoryQuery extends ActiveQuery
{
    /**
     * @return CategoryQuery
     */
    public function active()
    {
        return $this->andWhere(['status' => CustomActiveRecord::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @return Category[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Category|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return array
     */
    public function getParentCategories()
    {
        return $this->select(['title', 'id'])
            ->where(['parent_id' => null])
            ->active()
            ->indexBy('id')
            ->orderBy('title')
            ->column();
    }

    /**
     * @return array
     */
    public function getAllCategories()
    {
        return $this->where(['not', ['parent_id' => null]])
            ->active()
            ->orderBy('title')
            ->all();
    }

    /**
     * @param $id
     * @return array
     */
    public function getSubCategories($id)
    {
        return $this->select(['title', 'id'])
            ->where(['parent_id' => $id])
            ->active()
            ->indexBy('id')
            ->orderBy(['priority' => SORT_DESC, 'title' => SORT_ASC])
            ->column();
    }
}
