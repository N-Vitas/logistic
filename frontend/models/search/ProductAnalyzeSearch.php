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
    public $product_balance;
    public $date_from;
    public $date_to;
    public $groups;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['created_at','increase','decrease','product_title', 'product_article', 'product_barcode', 'product_nomenclature', 'product_code_client','product_balance'], 'string'],
            [['date_from','date_to','groups'],'safe']
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'product_article',
            'product_barcode',
            'product_nomenclature',
            'product_code_client',
            'product_balance',
            'date_from' => 'Выбор перриода',
            'groups' => 'Группировка',
        ]);
    }

    public function search($client_id, $params)
    {

        $query = self::find()
            ->where(['client_id' => $client_id])->joinWith('product');
        
        // $query->andWhere(['>', 'product_analytics.increase', 0]);
        // $query->andWhere(['>', 'product_analytics.decrease', 0]);

        // if(!empty($this->date_to) && !empty($this->date_from)){
        //     $query->andFilterWhere(['between', 'product_analytics.created_at', $this->date_from, $this->date_to]);      
        // }
        
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        $dataProvider->setSort([
            'defaultOrder' => ['created_at' => SORT_DESC],
            'attributes' => [
                'increase',
                'decrease',
                'created_at',
                'product_title' => [
                    'asc' => ['products.title' => SORT_ASC],
                    'desc' => ['products.title' => SORT_DESC],
                ], 
                'product_article' => [
                    'asc' => ['products.article' => SORT_ASC],
                    'desc' => ['products.article' => SORT_DESC],
                ], 
                'product_barcode' => [
                    'asc' => ['products.barcode' => SORT_ASC],
                    'desc' => ['products.barcode' => SORT_DESC],
                ], 
                'product_nomenclature' => [
                    'asc' => ['products.nomenclature' => SORT_ASC],
                    'desc' => ['products.nomenclature' => SORT_DESC],
                ], 
                'product_code_client' => [
                    'asc' => ['products.code_client' => SORT_ASC],
                    'desc' => ['products.code_client' => SORT_DESC],
                ], 
                'product_balance' => [
                    'asc' => ['products.balance' => SORT_ASC],
                    'desc' => ['products.balance' => SORT_DESC],
                ]
            ]
        ]);    

        if(!$this->load($params)){
            return $dataProvider;
        }
        
        if(!empty($this->groups)){
            $query->groupBy(['products.title','product_analytics.increase']);
        }
        
        if (!empty($this->date_from)) {
            $query->andWhere(['>=', 'product_analytics.created_at', $this->date_from]);
        }

        if (!empty($this->date_to)) {
            $query->andWhere(['<=', 'product_analytics.created_at', $this->date_to]);
        }
        if ($this->created_at) {
            $query->andWhere(['like', 'product_analytics.created_at', $this->created_at]);
        }
        if ($this->increase) {
            $query->andWhere(['like', 'product_analytics.increase', $this->increase]);
        }
        if ($this->decrease) {
            $query->andWhere(['like', 'product_analytics.decrease', $this->decrease]);
        }
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
        if ($this->product_balance) {
            $query->andWhere(['like', 'products.balance', $this->product_balance]);
        }

        return $dataProvider;
    }
}