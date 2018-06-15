<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Filter extends Model
{
    public $sub_categories;
    public $tags;
    public $features = [];

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['sub_categories', 'tags', 'features'], 'safe'],
        ];
    }

    /**
     * @return array the labels form.
     */
    public function attributeLabels()
    {
        return [
            'sub_categories' => Yii::t('app', 'Type'),
            'tags' => Yii::t('app', 'Tags'),
            'features' => Yii::t('app', 'Features'),
        ];
    }
}