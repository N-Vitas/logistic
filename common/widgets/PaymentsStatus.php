<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 21-Mar-16
 * Time: 17:09
 */

namespace common\widgets;
use Yii;
use common\models\Client;
use common\models\Order;
use common\models\DeliverySearch;
use yii\base\Widget;

class PaymentsStatus extends Widget
{
  public $client;
  public $client_id;
  private $finishedPayments = 0;
	private $toFinishPayments = 0;
  private $cancelPayments = 0;

  public function init()
  {
  	if (!empty($this->client)) {
      $this->client_id = $this->client->id;
    }
    if (empty($this->client) && $this->client_id) {
      $this->client = Client::find()->where(['id' => $this->client_id])->one();
    }    
    $searchModel = new DeliverySearch();
  	$finished = $searchModel->search($this->client->is_id,Yii::$app->request->queryParams);
  	$toFinish = $searchModel->search($this->client->is_id,Yii::$app->request->queryParams);
    $canceled = $searchModel->search($this->client->is_id,Yii::$app->request->queryParams);
  	$this->finishedPayments = $finished->query
  		->andFilterWhere(['orders.payment_type' => Order::PAYMENT_COD])
  		->andFilterWhere(['orders.status' => Order::STATUS_COMPLETE])
  		->sum('orders.price');
    $this->toFinishPayments = $toFinish->query
  		->andFilterWhere(['orders.payment_type' => Order::PAYMENT_COD])
    	->andFilterWhere(['NOT IN', 'orders.status', [Order::STATUS_COMPLETE, Order::STATUS_CANCELED]])
    	->sum('orders.price'); 
    $this->cancelPayments = $canceled->query
      ->andFilterWhere(['orders.payment_type' => Order::PAYMENT_COD])
      ->andFilterWhere(['orders.status' => Order::STATUS_CANCELED])
      ->sum('orders.price');   
  }

  public function run()
  {
    return $this->render('payments-status', [
    	'finishedPayments' => $this->finishedPayments,
    	'toFinishPayments' => $this->toFinishPayments,
      'cancelPayments' => $this->cancelPayments,
    ]);      
  }
}
