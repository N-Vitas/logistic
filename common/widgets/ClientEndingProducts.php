<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 21-Mar-16
 * Time: 17:09
 */

namespace common\widgets;


use common\models\Client;
use yii\base\Widget;
use common\models\Product;

class ClientEndingProducts extends Widget
{
    /**
     * @var $client Client клиент, по которому отображается информация
     */
    public $client;
    public $client_id;

    private $endingProducts = [];
    private $endedProducts = [];
    private $endingProductsCount = 0;
    private $endedProductsCount = 0;

    public function init()
    {
        if (!empty($this->client)) {
            $this->client_id = $this->client->id;
        }
        if (empty($this->client) && $this->client_id) {
            $this->client = Client::find()->where(['id' => $this->client_id])->one();
        }
        $products = Product::find()->where(['client_id' => $this->client->is_id])
            ->orderBy('balance ASC')
            ->all();
        foreach ($products as $product) {
            $balance = $product->getBalance()->one();
            if($balance){
                if(preg_replace('/\s/',"",$product->balance) <= $balance->min_balance){
                    $this->endingProducts[] = $product;
                    $this->endingProductsCount++;
                }
                if(preg_replace('/\s/',"",$product->balance) == 0){
                    $this->endedProducts[] = $product;
                    $this->endedProductsCount++;
                }
            }
        }
    }

    public function run()
    {
        return $this->render(
            'client-ending-products',
            [
                'endingProducts' => $this->endingProducts,
                'endedProducts' => $this->endedProducts,
                'endingProductsCount' => $this->endingProductsCount,
                'endedProductsCount' => $this->endedProductsCount,
            ]
        );
    }
}