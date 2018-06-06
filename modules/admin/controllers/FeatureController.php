<?php

namespace app\modules\admin\controllers;

use app\models\User;
use Yii;
use app\modules\admin\models\Feature;
use app\modules\admin\models\FeatureSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FeatureController implements the CRUD actions for Feature model.
 */
class FeatureController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
     * @param $action
     * @return bool|\yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (Yii::$app->session->get('user.role') < User::USER_ADMIN) {
            return $this->redirect(['/site/error']);
        }

        if (!parent::beforeAction($action)) {
            return false;
        }

        return true;
    }

    /**
     * Lists all Feature models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeatureSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Feature model.
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
     * Creates a new Feature model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Feature();
        $model->loadDefaultValues();

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
            return $this->redirect(['view', 'id' => $model->id]);

        } while (0);

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Feature model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

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

            if ($model->version != $model->oldAttributes['version']) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Data changed'));
                break;
            }
            $model->version += 1;

            if (!$model->save(false)) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Error saving'));
                break;
            }
            return $this->redirect(['view', 'id' => $model->id]);

        } while (0);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Feature model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Feature model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Feature the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Feature::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
