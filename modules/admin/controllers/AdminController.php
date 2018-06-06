<?php

namespace app\modules\admin\controllers;

use app\models\User;
use app\modules\admin\models\Product;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Admin controller for the `admin` module
 */
class AdminController extends Controller
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
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGent()
    {
        $str = '';
        $r = 1; // tbl_tag_relations
//        $r = 2; // tbl_values

        do {
            if ($r === 1) {
                for ($i = 1; $i < 463; $i++) {
                    $k = rand(2, 8);
                    $str .= sprintf("(%d,'%d'),", $i, $k);
                    $str .= PHP_EOL;
                }
                break;
            }

            if ($r === 2) {
                $brands_1 = ['A-Bicycles','B-Bicycles','C-Bicycles','D-Bicycles','F-Bicycles'];
                $brands_2 = ['G-Parts','H-Parts','I-Parts'];
                $brands_3 = ['J-Accessories','K-Accessories','L-Accessories'];

                $m_r = ['Сталь', 'Алюминий'];

                $size = ['14','16','18','20','24','26','27,5','28','29'];

                $color = ['Белый','Желтый','Красный','Зеленый ','Синий','Черный'];

                $products = Product::find()->select(['id', 'category_id'])->orderBy('id')->all();
                foreach ($products as $product) {
                    switch ($product->category_id) {
                        case 2:
                        case 3:
                        case 5:
                        case 6:
                        case 7:
                            $i = rand(0, 4);
                            $str .= sprintf("(%d,1,'%s'),", $product->id, $brands_1[$i]);
                            $str .= PHP_EOL;
                            $i = rand(0, 1);
                            $str .= sprintf("(%d,2,'%s'),", $product->id, $m_r[$i]);
                            $str .= PHP_EOL;
                            $i = rand(0, 5);
                            $str .= sprintf("(%d,4,'%s'),", $product->id, $color[$i]);
                            $str .= PHP_EOL;
                            break;
                        case 8:
                        case 9:
                        case 10:
                            $i = rand(0, 2);
                            $str .= sprintf("(%d,1,'%s'),", $product->id, $brands_2[$i]);
                            $str .= PHP_EOL;
                            $i = rand(0, 8);
                            $str .= sprintf("(%d,3,'%s'),", $product->id, $size[$i]);
                            $str .= PHP_EOL;
                            break;
                        case 11:
                        case 12:
                        case 13:
                        case 14:
                        case 15:
                        case 16:
                            $i = rand(0, 2);
                            $str .= sprintf("(%d,1,'%s'),", $product->id, $brands_2[$i]);
                            $str .= PHP_EOL;
                            break;
                        default:
                            $i = rand(0, 2);
                            $str .= sprintf("(%d,1,'%s'),", $product->id, $brands_3[$i]);
                            $str .= PHP_EOL;
                    }
                }
                break;
            }

        } while (0);

        $file = \Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'features.txt';
        file_put_contents($file, $str);

        echo 'Фсё';
    }
}
