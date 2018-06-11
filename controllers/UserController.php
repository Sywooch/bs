<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
//                'only' => ['create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the Home page.
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new User();
        $model->loadDefaultValues();

        do {
            if (!Yii::$app->request->isPost) break;

            if (!$model->load(Yii::$app->request->post())) break;

            if (!$model->validate()) {
                Yii::$app->session->addFlash('error', Yii::t('app', 'Validation error'));
                break;
            }

            $model->setPassword($model->password);

            if (!$model->save(false)) {
                Yii::$app->session->addFlash('error', Yii::t('app', 'Error saving'));
                break;
            }

            return $this->goBack();

//            if (Yii::$app->request->isAjax) {
//                Yii::$app->response->format = Response::FORMAT_JSON;
//                return ActiveForm::validate($model, 'email');
//            }

        } while (0);

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\base\Exception
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->user->id);

        do {
            if (!Yii::$app->request->isPost) break;

            if (!$model->load(Yii::$app->request->post())) break;

            if (!$model->validate()) {
                Yii::$app->session->addFlash('error', Yii::t('app', 'Validation error'));
                break;
            }

            $model->setPassword($model->password);

            if (!$model->save(false)) {
                Yii::$app->session->addFlash('error', Yii::t('app', 'Error saving'));
                break;
            }

            return $this->goBack();

        } while (0);

        $model->password = '';
        return $this->render('/cabinet/index', [
            'title' => Yii::t('app', Yii::t('app', 'Personal Data')),
            'page' => '/user/_form',
            'content' => [
                'model' => $model
            ],
        ]);
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
