<?php

namespace app\modules\admin\models;

use app\models\CustomActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Tag]].
 *
 * @see Tag
 */
class TagQuery extends ActiveQuery
{
    /**
     * @return TagQuery
     */
    public function active()
    {
        return $this->andWhere(['status' => CustomActiveRecord::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @return Tag[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tag|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return array
     */
    public function getListTags()
    {
        return $this->select(['title', 'id'])
            ->active()
            ->indexBy('id')
            ->orderBy('title')
            ->column();
    }
}
