<?php

namespace frontend\controllers;

use Yii;
use common\models\Order;
use common\models\DeliverySearch;
use frontend\components\BaseController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
/**
 * OrderController implements the CRUD actions for Order model.
 */
class DeliveryController extends BaseController
{

  public $toXls = "";
  public function init()
  {
    parent::init();
    $this->toXls = empty($_GET['xls']) ? "" : "xls-";
  }
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

    return $this->render($this->toXls.'index', [
      'columns' => $this->showColumns,
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      'time' => date('H:i:s'),
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
