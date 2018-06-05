<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Value;
use app\modules\admin\models\ValueSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ValueController implements the CRUD actions for Value model.
 */
class ValueController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Value models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ValueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Value model.
     * @param string $product_id
     * @param string $feature_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($product_id, $feature_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($product_id, $feature_id),
        ]);
    }

    /**
     * Creates a new Value model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param null $product_id
     * @return mixed
     */
    public function actionCreate($product_id = null)
    {
        $model = new Value();
        $model->loadDefaultValues();
        $model->product_id = $product_id;

        do {
            if (!Yii::$app->request->isPost) {
                break;
            }
            if (!$model->load(Yii::$app->request->post())) {
                break;
            }
            if (!$model->validate()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Validation error'));
                break;
            }
            if (!$model->save(false)) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Error saving'));
                break;
            }
            return $this->redirect(['product/view', 'id' => $model->product_id]);

        } while (0);

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Value model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $product_id
     * @param string $feature_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($product_id, $feature_id)
    {
        $model = $this->findModel($product_id, $feature_id);

        do {
            if (!Yii::$app->request->isPost) {
                break;
            }
            if (!$model->load(Yii::$app->request->post())) {
                break;
            }
            if (!$model->validate()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Validation error'));
                break;
            }

            if (!$model->save(false)) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Error saving'));
                break;
            }
            return $this->redirect(['product/view', 'id' => $model->product_id]);

        } while (0);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Value model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $product_id
     * @param string $feature_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($product_id, $feature_id)
    {
        $this->findModel($product_id, $feature_id)->delete();

        return $this->redirect(['product/view', 'id' => $product_id]);
    }

    /**
     * Finds the Value model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $product_id
     * @param string $feature_id
     * @return Value the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($product_id, $feature_id)
    {
        if (($model = Value::findOne(['product_id' => $product_id, 'feature_id' => $feature_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
