<?php

namespace app\modules\admin\models;

use app\models\CustomActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Feature]].
 *
 * @see Feature
 */
class FeatureQuery extends ActiveQuery
{
    /**
     * @return FeatureQuery
     */
    public function active()
    {
        return $this->andWhere(['status' => CustomActiveRecord::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @return Feature[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Feature|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return array
     */
    public function getListFeatures()
    {
        return $this->select(['title', 'id'])
            ->active()
            ->indexBy('id')
            ->orderBy('title')
            ->column();
    }
}
