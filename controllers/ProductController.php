<?php

namespace app\controllers;

use app\models\Filter;
use app\models\Product;
use app\models\ProductSearch;
use app\modules\admin\models\Category;
use app\modules\admin\models\TagRelation;
use app\modules\admin\models\Value;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
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
     * @return string
     */
    public function actionList()
    {
        $params = Yii::$app->request->queryParams;

        do {
            $filter = new Filter();
            $filter->load(Yii::$app->request->get());

            if (!empty($filter->sub_categories)) {
                $params['category_id'] = array_filter($filter->sub_categories);
            }
            if (!empty($filter->tags)) {
                $params['tags'] = array_filter($filter->tags);
            }
//            if (!empty($filter->features)) {
//                $params['features'] = array_filter($filter->features);
//            }

            $arr_url = [];
            if (isset($params['r'])) {
                $arr_url['r'] = $params['r'];
            }
            if (isset($params['parent_id'])) {
                $id = intval($params['parent_id']);
                $arr_url['p'] = 'parent_id';
                $arr_url['id'] = $id;
            }
            if (isset($params['category_id'])) {
                $id = intval($params['category_id']);
                $arr_url['p'] = 'category_id';
                $arr_url['id'] = $id;
            }
            if (empty($id)) break;

            $category = Category::findOne($id);
            if (empty($category)) break;

            if (empty($category->parent_id)) {
                $sub_categories = Category::find()->getSubCategories($id);
                $category_id = array_keys($sub_categories);
            } else {
                $sub_categories = Category::find()->getSubCategories($category->parent_id);
                $category_id[] = $id;
            }

            $searchModel = new ProductSearch();
            $dataProvider = $searchModel->search($params);

            $tags = TagRelation::find()->getTagsByCategory($category_id);
//            $features = Value::find()->getFeaturesByCategory($category_id);

            return $this->render('list', [
                'dataProvider' => $dataProvider,
                'category' => empty($category) ? '' : $category->title,
                'model' => $filter,
                'sub_categories' => $sub_categories,
                'tags' => ArrayHelper::map($tags, 'tag_id', "tag.title"),
//                'features' => ArrayHelper::map($features, 'value', 'value', 'feature_id'),
                'arr_url' => $arr_url,
            ]);

        } while (0);

        return $this->goHome();
    }

    /**
     * @return string
     */
    public function actionPopular()
    {
        $params = Yii::$app->request->queryParams;
        if (isset($params['parent_id'])) {
            $category = Category::findOne($params['parent_id']);
        }

        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('popular', [
            'dataProvider' => $dataProvider,
            'category' => empty($category) ? '' : $category->title
        ]);
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
