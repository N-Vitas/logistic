<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 27-апр-16
 * Time: 00:52
 */

namespace frontend\models\search;

use common\models\ProductAnalytics;
use yii\data\ActiveDataProvider;

class ProductAnalyzeSearch extends ProductAnalytics
{
    public $product_title;
    public $product_article;
    public $product_barcode;
    public $product_nomenclature;
    public $product_code_client;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['product_title', 'product_article', 'product_barcode', 'product_nomenclature', 'product_code_client'], 'string']
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'product_article',
            'product_barcode',
            'product_nomenclature',
            'product_code_client'
        ]);
    }

    public function search($client_id, $post, $dateFrom = false, $dateTo = false)
    {

        $query = self::find()
            ->where(['client_id' => $client_id])->joinWith('product');
        
        if (!empty($dateFrom)) {
            $query->andWhere(['>=', 'product_analytics.created_at', $dateFrom]);
        }

        if (!empty($dateTo)) {
            $query->andWhere(['<=', 'product_analytics.created_at', $dateTo]);
        }
        
        $dataProvider = new ActiveDataProvider(['query' => $query, 'sort' => [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ]]);

        $this->load($post);

        if ($this->product_article) {
            $query->andWhere(['like', 'products.article', $this->product_article]);
        }
        if ($this->product_nomenclature) {
            $query->andWhere(['like', 'products.nomenclature', $this->product_nomenclature]);
        }
        if ($this->product_barcode) {
            $query->andWhere(['like', 'products.barcode', $this->product_barcode]);
        }
        if ($this->product_code_client) {
            $query->andWhere(['like', 'products.code_client', $this->product_code_client]);
        }
        if ($this->product_title) {
            $query->andWhere(['like', 'products.title', $this->product_title]);
        }

        return $dataProvider;
    }
}