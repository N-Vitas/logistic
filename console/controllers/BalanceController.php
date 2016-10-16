<?php

namespace console\controllers;


use yii\console\Controller;
use common\models\Product;
use common\models\Balance;
/**
* Пакет обработки продуктов.
*/
class BalanceController extends Controller
{
    /**
    * Перебирает базу продуктов и добовляет минимальное кол-во остатка для уведомления.
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
}