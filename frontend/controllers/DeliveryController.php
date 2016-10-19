<?php

namespace frontend\controllers;

use Yii;
use common\models\Order;
use common\models\DeliverySearch;
use frontend\components\BaseController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class DeliveryController extends BaseController
{
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
        $searchModel = new DeliverySearch();
        $dataProvider = $searchModel->search($this->client->is_id,Yii::$app->request->queryParams);

        return $this->render('index', [
            'columns' => $this->showColumns,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'deliveredYesterday' => $deliveredYesterday,
            'deliveredToday' => $deliveredToday,
            'toDeliver' => $toDeliver
        ]);
    }
}
