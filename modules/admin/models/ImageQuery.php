<?php

namespace app\modules\admin\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Image]].
 *
 * @see Image
 */
class ImageQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Image[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Image|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
