<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 21-Mar-16
 * Time: 17:09
 */

namespace common\widgets;

use common\models\Client;
use common\models\Order;
use yii\base\Widget;

class DeliveryStatus extends Widget
{
  /**
   * @var $client Client клиент, по которому отображается информация
   */
  public $client;
  public $client_id;
  private $deliveredYesterday;
  private $deliveredToday;
  private $toDeliver;

  public function init()
  {
    $yesterdayBegin = date('Y-m-d H:i:s',mktime(date("H"), date("i"), date("s"), date("m")  , date("d")-1, date("Y")));
    $yesterdayEnd = date('Y-m-d H:i:s',mktime(date("H"), date("i"), date("s"), date("m")  , date("d"), date("Y")));
    if (!empty($this->client)) {
      $this->client_id = $this->client->id;
    }
    if (empty($this->client) && $this->client_id) {
      $this->client = Client::find()->where(['id' => $this->client_id])->one();
    }
    $this->deliveredYesterday = Order::find()
        ->where(['between', 'delivery_date', $yesterdayBegin, $yesterdayEnd])
        ->andWhere(['client_id' => $this->client->is_id])
        ->andWhere(['status' => Order::STATUS_COMPLETE])
        ->count();
    $this->deliveredToday = Order::find()
        ->where(['>', 'delivery_date', $yesterdayEnd])
        ->andWhere(['client_id' => $this->client->is_id])
        ->andWhere(['status' => Order::STATUS_COMPLETE])
        ->count();
    $this->toDeliver = Order::find()
        ->andWhere(['client_id' => $thisclient->is_id])
        ->where(['in', 'status', Order::STATUS_DELIVERING])
        ->count();
  }

  public function run()
  {
    return $this->render('delivery-status', [
      'deliveredYesterday' => $this->deliveredYesterday,
      'deliveredToday' => $this->deliveredToday,
      'toDeliver' => $this->toDeliver
    ]);      
  }
}
