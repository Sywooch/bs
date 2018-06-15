<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Filter extends Model
{
    public $features = [];
    public $tags;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['features', 'tags'], 'safe'],
            [['email'], 'string', 'length' => [5, 50]],
        ];
    }

    /**
     * @return array the labels form.
     */
    public function attributeLabels()
    {
        return [
            'features' => Yii::t('app', 'Features'),
            'tags' => Yii::t('app', 'Tags'),
        ];
    }
}