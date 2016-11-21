<?php
/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 11-мая-16
 * Time: 02:34
 */

namespace frontend\controllers;

use Yii;
use common\models\Order;
use common\models\Client;
use common\models\NotificationSettings;
use common\models\SearchAnalitic;
use common\models\SearchClient;
use frontend\components\BaseController;
use frontend\models\ClientUser;
use frontend\models\search\ProductAnalyzeSearch;
use frontend\models\ProductSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class AnalyticController extends BaseController
{
    public $toXls = "";

    public function init()
    {
        parent::init();

        $this->toXls = empty($_GET['xls']) ? "" : "xls-";
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

    public function actionDelivery()
    {
      $searchModel = new SearchAnalitic();
      $dataProvider = $searchModel->search($this->client->is_id,Yii::$app->request->queryParams);

      return $this->render($this->toXls.'index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'toXls' => $this->toXls,
        'view' =>  $this->list_view
      ]);
    }

    public function actionPayments()
    {
      $searchModel = new SearchAnalitic();
      $dataProvider = $searchModel->search($this->client->is_id,Yii::$app->request->queryParams);
      $dataProvider->query->andWhere(['orders.payment_type' => Order::PAYMENT_COD]);

      return $this->render($this->toXls.'payments', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'toXls' => $this->toXls,
        'view' =>  $this->list_view
      ]);
    }

    public function actionUser()
    {

        $searchModel = new ClientUser();
        $dataProvider = $searchModel->search($this->client_id,Yii::$app->request->queryParams);

        return $this->render($this->toXls.'user', [
          'dataProvider' => $dataProvider,
          'searchModel' => $searchModel,
          'view' =>  $this->list_view
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

      return $this->render($this->toXls.'motion', [
        'columns' => $columns,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
        'view' =>  $this->list_view
      ]);
    }

    public function actionProduct($dateFrom = false, $dateTo = false)
    {
      $searchModel = new ProductSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->andWhere(['client_id' => $this->client->is_id]);

      return $this->render('product', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'columns' => $this->showColumns,
        'view' =>  $this->list_view
      ]);
    }


  public function actionView($id)
  {
    $model = Order::findOne($id);
    if($model == null){
      throw new NotFoundHttpException('The requested page does not exist.');
    }
    return $this->render('view', compact('model'));
  }
}