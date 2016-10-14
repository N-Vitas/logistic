<?php
/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 11-мая-16
 * Time: 02:34
 */

namespace frontend\controllers;


use common\models\Order;
use frontend\components\BaseController;
use common\models\Client;
use common\models\NotificationSettings;
use frontend\models\ClientUser;
use frontend\models\search\ProductAnalyzeSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class AnalyzeController extends BaseController
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

    public function actionUser($dateFrom = false, $dateTo = false)
    {

        $query = ClientUser::find()
            ->where(['user.client_id' => $this->client_id]);


        if (!empty($dateFrom)) {
            $query->andWhere(['>=', 'created_at', strtotime($dateFrom)]);
        }

        if (!empty($dateTo)) {
            $query->andWhere(['<=', 'created_at', strtotime($dateTo)]);
        }

        $dataProvider = new ActiveDataProvider(['query' => $query, 'sort' => [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ]]);

        return $this->render($this->toXls.'user', [
            'dataProvider' => $dataProvider,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    public function actionProduct($dateFrom = false, $dateTo = false)
    {
        $searchModel = new ProductAnalyzeSearch();

        if (isset($_GET['dateFrom']))
            $dateFrom = $_GET['dateFrom'];

        if (isset($_GET['dateTo']))
            $dateTo = $_GET['dateTo'];

        $dataProvider = $searchModel->search($this->client->is_id, \Yii::$app->request->get(), $dateFrom, $dateTo);

        $columns = [];
        foreach ($this->getClientColumns() as $key => $col) {
            $columns[] = [
                'value' => 'product.' . $col,
                'attribute' => 'product_' . $col,
            ];
        }

        return $this->render($this->toXls.'product', [
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
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

        return $this->render($this->toXls.'order', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'finishedPayments' => $finishedPayments,
            'toFinishPayments' => $toFinishPayments
        ]);
    }

    public function actionPayments($dateFrom = false, $dateTo = false)
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

        return $this->render($this->toXls.'payments', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'finishedPayments' => $finishedPayments,
            'toFinishPayments' => $toFinishPayments
        ]);
    }
}