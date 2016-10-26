<?php
/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 11-мая-16
 * Time: 02:34
 */

namespace backend\controllers;

use yii;
use backend\components\BaseController;
use common\models\Client;
use common\models\NotificationSettings;
use common\models\Order;
use common\models\SearchAnalitic;
use frontend\models\ClientUser;
use frontend\models\search\ProductAnalyzeSearch;
use frontend\models\ProductSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class AnalyticController extends BaseController
{
    public $clients;
    public $client_id;

    /**
     * @var Client
     */
    public $client;

    public function init()
    {
        parent::init();

        $clients = Client::find()->asArray()->all();
        $this->clients = ArrayHelper::map($clients, 'id', 'name');

        if (!empty($_POST['client_id'])) {
            $this->client_id = $_POST['client_id'];
        } else if (!$this->client_id = \Yii::$app->session->get('service_client_id')) {
            foreach ($this->clients as $id => $name) {
                $this->client_id = $id;
                break;
            }  
        }
        \Yii::$app->session->set('service_client_id', $this->client_id);

        $this->client = Client::findOne($this->client_id);
    }

     public function actions()
    {
        if(!empty($_POST['client_id'])){
            unset($_GET);
        }
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function getClientColumns()
    {
        $columns = [];

        $settings = NotificationSettings::initClient($this->client_id);

        if ($settings->show_article) {
            $columns[] = 'article';
        }
        if ($settings->show_barcode) {
            $columns[] = 'barcode';
        }
        if ($settings->show_code_client) {
            $columns[] = 'code_client';
        }

        return $columns;
    }

    public function actionUser($dateFrom = false, $dateTo = false)
    {

        $query = ClientUser::find()
            ->where(['user.client_id' => $this->client_id]);
//            ->

        // if (!empty($dateFrom)) {
        //     $query->andWhere(['>=', 'created_at', strtotime($dateFrom)]);
        // }

        // if (!empty($dateTo)) {
        //     $query->andWhere(['<=', 'created_at', strtotime($dateTo)]);
        // }

        $dataProvider = new ActiveDataProvider(['query' => $query, 'sort' => [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ]]);

        return $this->render('user', [
            'dataProvider' => $dataProvider,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    public function actionMotion($dateFrom = false, $dateTo = false)
    {
      $searchModel = new ProductAnalyzeSearch();
      $dataProvider = $searchModel->search($this->client->is_id, \Yii::$app->request->queryParams);

      $columns = [];
      foreach ($this->getClientColumns() as $key => $col) {
        $columns[] = [
          'value' => 'product.' . $col,
          'attribute' => 'product_' . $col,
        ];
        }

      return $this->render('motion', [
        'columns' => $columns,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel
      ]);
    }

    public function actionProduct($dateFrom = false, $dateTo = false)
    {
      $searchModel = new ProductSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->andWhere(['client_id' => $this->client->is_id]);
      $columns = [];
      foreach ($this->getClientColumns() as $key => $col) {
        $columns[] = [
          'value' => 'product.' . $col,
          'attribute' => 'product_' . $col,
        ];
        }
      return $this->render('product', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'columns' => $columns,
      ]);

        // $searchModel = new ProductAnalyzeSearch();

        // if (isset($_GET['dateFrom']))
        //     $dateFrom = $_GET['dateFrom'];

        // if (isset($_GET['dateTo']))
        //     $dateTo = $_GET['dateTo'];

        // $dataProvider = $searchModel->search($this->client->is_id, \Yii::$app->request->get(), $dateFrom, $dateTo);

        // $columns = [];
        // foreach ($this->getClientColumns() as $key => $col) {
        //     $columns[] = [
        //         'value' => 'product.' . $col,
        //         'attribute' => 'product_' . $col,
        //     ];
        // }

        // return $this->render('product', [
        //     'columns' => $columns,
        //     'dataProvider' => $dataProvider,
        //     'searchModel' => $searchModel,
        //     'dateFrom' => $dateFrom,
        //     'dateTo' => $dateTo
        // ]);
    }

    public function actionDelivery()
    {
      $searchModel = new SearchAnalitic();
      $dataProvider = $searchModel->search($this->client->is_id,Yii::$app->request->queryParams);

      return $this->render('delivery', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'client_id' => $this->client->id,
      ]);
    }

    public function actionOrder($dateFrom = false, $dateTo = false)
    {
        $searchModel = new \common\models\OrderAnalyticsSearch();
        $searchModel->load(\Yii::$app->request->get());

        if (isset($_GET['dateFrom']))
            $dateFrom = $_GET['dateFrom'];

        if (isset($_GET['dateTo']))
            $dateTo = $_GET['dateTo'];

        $dataProvider = $searchModel->search($this->client->is_id, \Yii::$app->request->get(), $dateFrom, $dateTo);

        $finishedPayments = $searchModel->search($this->client->is_id, \Yii::$app->request->get(), $dateFrom, $dateTo)
            ->query->andWhere(['orders.status' => Order::STATUS_COMPLETE])
            ->sum('orders.price');
        $toFinishPayments = $searchModel->search($this->client->is_id, \Yii::$app->request->get(), $dateFrom, $dateTo)
            ->query->andWhere(['NOT IN', 'orders.status', [Order::STATUS_COMPLETE, Order::STATUS_CANCELED]])
            ->sum('orders.price');

        return $this->render('order', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'finishedPayments' => $finishedPayments,
            'toFinishPayments' => $toFinishPayments
        ]);
    }
  public function actionPayments()
  {
    $searchModel = new SearchAnalitic();
    $dataProvider = $searchModel->search($this->client->is_id,Yii::$app->request->queryParams);
    $dataProvider->query->andWhere(['orders.payment_type' => Order::PAYMENT_COD]);

    return $this->render('payments', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      'client_id' => $this->client->id,
    ]);
  }

    // public function actionPayments($dateFrom = false, $dateTo = false)
    // {
    //     $searchModel = new \common\models\OrderAnalyticsSearch();
    //     $searchModel->load(\Yii::$app->request->get());

    //     if (isset($_GET['dateFrom']))
    //         $dateFrom = $_GET['dateFrom'];

    //     if (isset($_GET['dateTo']))
    //         $dateTo = $_GET['dateTo'];

    //     $dataProvider = $searchModel->search($this->client->is_id, \Yii::$app->request->get(), $dateFrom, $dateTo);

    //     $finishedPayments = $searchModel->search($this->client->is_id, \Yii::$app->request->get(), $dateFrom, $dateTo)
    //         ->query->andWhere(['orders.status' => Order::STATUS_COMPLETE])
    //         ->sum('orders.price');
    //     $toFinishPayments = $searchModel->search($this->client->is_id, \Yii::$app->request->get(), $dateFrom, $dateTo)
    //         ->query->andWhere(['NOT IN', 'orders.status', [Order::STATUS_COMPLETE, Order::STATUS_CANCELED]])
    //         ->sum('orders.price');

    //     return $this->render('payments', [
    //         'dataProvider' => $dataProvider,
    //         'searchModel' => $searchModel,
    //         'dateFrom' => $dateFrom,
    //         'dateTo' => $dateTo,
    //         'finishedPayments' => $finishedPayments,
    //         'toFinishPayments' => $toFinishPayments
    //     ]);
    // }
  public function actionView($id)
  {
    $model = Order::findOne($id);
    if($model == null){
      throw new NotFoundHttpException('The requested page does not exist.');
    }
    return $this->render('view', compact('model'));
  }
}