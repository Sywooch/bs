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
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

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
}
