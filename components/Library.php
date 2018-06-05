<?php

namespace app\components;

use yii\helpers\FileHelper;

class Library
{
    /**
     * @param $store_dir
     * @return bool
     * @throws \yii\base\Exception
     */
    public static function checkDir($store_dir)
    {
        $basePath = \Yii::getAlias('@webroot');

        if (!is_dir($basePath . DIRECTORY_SEPARATOR . $store_dir)) {
            FileHelper::createDirectory($basePath . DIRECTORY_SEPARATOR . $store_dir);
        }

        return is_writable($store_dir);
    }

}