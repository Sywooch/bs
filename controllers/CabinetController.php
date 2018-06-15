<?php

namespace app\controllers;

use app\models\User;
use app\modules\admin\models\OrderItemSearch;
use app\modules\admin\models\OrderSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class CabinetController extends Controller
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
                        'allow' => true,
                        'actions' => ['index', 'my-orders', 'order-detail'],
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
     * @return string
     */
    public function actionIndex()
    {
        /* @var $user User */
        $user = Yii::$app->user->identity;

        return $this->render('index', [
            'title' => Yii::t('app', 'Welcome, {userName}', ['userName' => $user->name]),
            'page' => null,
            'content' => null
        ]);
    }

    /**
     * @return string
     */
    public function actionMyOrders()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['user_id' => Yii::$app->user->id]);

        return $this->render('index', [
            'title' => Yii::t('app', Yii::t('app', 'List My Orders')),
            'page' => 'list-orders',
            'content' => [
                'dataProvider' => $dataProvider
            ],
        ]);
    }

    /**
     * @param $order_id
     * @return string
     */
    public function actionOrderDetail($order_id)
    {
        $searchModel = new OrderItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['order_id' => $order_id]);

        return $this->render('index', [
            'title' => Yii::t('app', Yii::t('app', 'Order Detail')),
            'page' => 'order_detail',
            'content' => [
                'dataProvider' => $dataProvider
            ],
        ]);
    }
}