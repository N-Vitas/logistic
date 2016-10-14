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

    public function init()
    {
        if (!empty($this->client)) {
            $this->client_id = $this->client->id;
        }
        if (empty($this->client) && $this->client_id) {
            $this->client = Client::find()->where(['id' => $this->client_id])->one();
        }

        $this->endingProducts = Product::find()
//            ->where(['<', 'balance', 20])
            ->where(['>', 'balance', 0])
            ->andWhere(['client_id' => $this->client->is_id])
            ->orderBy('balance ASC')
            ->limit(10)
            ->all();

        $this->endedProducts = Product::find()
            ->where(['balance' => 0])
            ->andWhere(['client_id' => $this->client->is_id])
            ->limit(20)
            ->all();
    }

    public function run()
    {
        return $this->render(
            'client-ending-products',
            [
                'endingProducts' => $this->endingProducts,
                'endedProducts' => $this->endedProducts,
            ]
        );
    }
}