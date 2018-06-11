<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Image;
use app\modules\admin\models\Product;
use app\modules\admin\models\ProductSearch;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends CustomController
{
    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new Product();
        $model->loadDefaultValues();

        do {
            if (!Yii::$app->request->isPost) {
                break;
            }
            if (!$model->load(Yii::$app->request->post())) {
                break;
            }

            if (!$model->validate()) {
                Yii::$app->session->addFlash('error', Yii::t('app', 'Validation error'));
                break;
            }
            if (!$model->save(false)) {
                Yii::$app->session->addFlash('error', Yii::t('app', 'Error saving'));
                break;
            }

            $model->updateTags();

            $image = new Image();
            $image->imageFile = UploadedFile::getInstance($model, 'img');
            if (!empty($image->imageFile)) {
                $image->uploadImage($model->id);
            }

            return $this->redirect(['view', 'id' => $model->id]);

        } while (0);

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        do {
            if (!Yii::$app->request->isPost) {
                break;
            }
//            var_dump(Yii::$app->request->post());die;
            if (!$model->load(Yii::$app->request->post())) {
                break;
            }
            if (!$model->validate()) {
                Yii::$app->session->addFlash('error', Yii::t('app', 'Validation error'));
                break;
            }

            if ($model->version != $model->oldAttributes['version']) {
                Yii::$app->session->addFlash('error', Yii::t('app', 'Data changed'));
                break;
            }
            $model->version += 1;

            if (!$model->save(false)) {
                Yii::$app->session->addFlash('error', Yii::t('app', 'Error saving'));
                break;
            }

            $model->updateTags();

            $image = Image::findOne(['product_id' => $id]);
            if (empty($image)) {
                $image = new Image();
            }
            $image->imageFile = UploadedFile::getInstance($model, 'img');
            if (!empty($image->imageFile)) {
                $image->uploadImage($model->id);
            }

            return $this->redirect(['view', 'id' => $model->id]);

        } while (0);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $image = Image::findOne(['product_id' => $id]);
        $image->removeImageFile();

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
