<?php

namespace console\controllers;

use yii;
use yii\console\Controller;
use common\models\Product;
use common\models\Balance;
use common\models\Client;
use common\models\NotificationSettings;
/**
* Пакет обработки баланса на складе.
*/
class BalanceController extends Controller
{
    public function actionTest()
    {
      $file = __DIR__."/../../test.txt";
      if(file_exists($file)){
        $fp = fopen($file, 'a');
      }else{
        $fp = fopen($file, 'w');
      }
      fwrite($fp, time()."\n"); // Запись в файл
      fclose($fp);
    }
    
    /**
    * Перебирает базу продуктов и добавляет минимальное кол-во остатка для уведомления.
    */
    public function actionIndex()
    {
      $products = Product::find()->all();
      $count=0;$save=0;
      foreach ($products as $product) {
        $balance = Balance::find()->where(['product_id' => $product->id])->one();            
        if(!$balance){
          $balance = new Balance();
          $balance->product_id = $product->id;
          $balance->balance = $product->balance;
          $balance->save();
          $save++;     
        }
        $count++; 
        echo '.';          
      }
      echo "\n";
      echo "Обработано ".$count.", создано ".$save." записей \n";
    }

  /**
  * Рассылка уведомлений заканчивающихся товаров
  */
  public function actionNotification()
  {
    $balances = Balance::find()->all();
    foreach ($balances as $balance) {
      if($balance->balance <= $balance->min_balance){
        $this->sendNotification($balance);
      }
    }
  }

  private function sendEmail($email,$balance)
  {
    return Yii::$app->mailer->compose(
        ['html' => 'sendMinBalance-html', 'text' => 'sendMinBalance-text'],
        ['balance' => $balance]
    )
    ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
    ->setTo($email)
    ->setSubject('Баланс на складе ' . \Yii::$app->name)
    ->send();
  }

  private function sendNotification($balance){
    $product = Product::findOne($balance->product_id);
    if($product){
      $client = Client::find()->where(['is_id' => $product->client_id])->one();
      if($client){
        $settings = NotificationSettings::find()->where(['client_id' => $client->id])->one();
        if($settings){
          $emails = array_diff(explode(',', $settings->emails),array(''));
          if(count($emails) > 0){
            foreach ($emails as $email) {
              if(!empty($email) && $this->sendEmail($email,$balance)){
                Yii::info("Send notification for $email", 'emailSend');  
              }              
            }
          }
          return false;
        }
        return false;        
      }
      return false;
    }
    return false; 
  }
}