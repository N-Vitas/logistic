<?php

namespace frontend\controllers;

use Yii;
use common\models\Order;
use common\models\Product;
use frontend\models\OrderSearch;
use frontend\components\BaseController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends BaseController
{

    public $list_view = 'table';

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ]);
    }
    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->client->is_id);

        return $this->render('index', [
            'columns' => $this->showColumns,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'view' =>  $this->list_view
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order([
            'client_id' => $this->client->is_id,
            'user_id' => \Yii::$app->user->id,
            'payment_type' => 1
        ]);
        // var_dump(Yii::$app->request->post());
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (isset($_POST['products'])) {
                $products = json_decode($_POST['products'], true);

                $query = [];
                if (!empty($products)) {
                    foreach ($products as $id => $product) {
                        $query[] = "({$model->id}, {$id}, {$product['quantity']}, {$product['price']})";
                        if($productModel = Product::findOne($id)){
                            $productModel->balance = $productModel->balance - $product['quantity'];
                            $productModel->reserve = $product['quantity'];
                            $productModel->save();
                        }
                    }

                    \Yii::$app->db
                        ->createCommand("INSERT INTO order_item (order_id, item_id, quantity, price) VALUES "
                            . implode(',', $query))
                        ->execute();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCancel($id)
    {
        $model = $this->findModel($id);
        $model->status = $model::STATUS_CANCELED;
        $model->exported = 0;
        $model->save();
        $this->redirect('index');
    }
}
