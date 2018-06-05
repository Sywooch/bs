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
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

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
}
