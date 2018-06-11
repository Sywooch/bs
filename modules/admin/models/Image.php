<?php

namespace app\modules\admin\models;

use app\components\Library;
use app\models\CustomActiveRecord;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%images}}".
 *
 * @property string $id
 * @property string $product_id
 * @property string $image
 * @property int $priority
 *
 * @property Product $product
 */
class Image extends CustomActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%images}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'image'], 'required'],
            [['product_id', 'priority'], 'integer'],
            [['image'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg',
                'maxSize' => Yii::$app->params['max_image_size']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class,
                'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'image' => Yii::t('app', 'Image'),
            'priority' => Yii::t('app', 'Priority'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     * @return ImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ImageQuery(get_called_class());
    }

    /**
     * @return bool
     */
    public function removeImageFile()
    {
        if (!empty($this->image)) {
            return FileHelper::unlink(Yii::$app->params['product_images'] . DIRECTORY_SEPARATOR . $this->image);
        }

        return true;
    }

    /**
     * @param $product_id
     * @return bool
     * @throws \yii\base\Exception
     */
    public function uploadImage($product_id)
    {
        $file_name = md5(uniqid()) . '.' . strtolower($this->imageFile->extension);

        if (!Library::checkDir(Yii::$app->params['product_images'])) {
            Yii::$app->session->addFlash('error', Yii::t('app', 'No img dir.'));
            return false;
        }

        $this->removeImageFile();

        if (!$this->imageFile->saveAs(Yii::$app->params['product_images'] . DIRECTORY_SEPARATOR . $file_name)) {
            Yii::$app->session->addFlash('error', Yii::t('yii', 'File upload failed.'));
            return false;
        }

        $this->image = $file_name;
        $this->product_id = $product_id;
        $this->priority = 1;

        return $this->save();
    }
}
