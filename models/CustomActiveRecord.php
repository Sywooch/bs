<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class CustomActiveRecord extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 0;

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                Yii::$app->session->addFlash('success', 'Запись добавлена.');
            } else {
                Yii::$app->session->addFlash('success', 'Запись изменена.');
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $msg
     * @return string
     */
//    public function getMessage($msg)
//    {
//        return ' - ' . Yii::t('app', $msg);
//    }
}