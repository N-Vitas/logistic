<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_analytics".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $decrease
 * @property integer $increase
 * @property string $created_at
 */
class ProductAnalytics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_analytics';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'decrease', 'increase'], 'required'],
            [['product_id', 'decrease', 'increase'], 'integer'],
            [['created_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Продукт',
            'decrease' => 'Уход',
            'increase' => 'Приход',
            'created_at' => 'Дата движения',
            'product_article' => 'Артикуль',
            'product_barcode' => 'Штрих-код',
            'product_code_client' => 'Код клиента',
            'product_title' => 'Наименование',
            'product_nomenclature' => 'Номенклатура',
            'product_balance' => 'Остатки на складе',
        ];
    }

    public function getProduct()
    {
        return self::hasOne(Product::className(), ['id' => 'product_id']);
    }

    public static function getOrCreateByDate($product_id, $date = false)
    {
        if (!$date) {
            $date = date('Y-m-d', time());
        }
        if (is_int($date)) {
            $date = date('Y-m-d', $date);
        }

        $model = self::findOne(['created_at' => $date, 'product_id' => $product_id]);
        if (empty($model)) {
            $model = new self([
                'created_at' => $date,
                'product_id' => $product_id,
                'increase' => 0,
                'decrease' => 0,
            ]);
            if (!$model->save()) {
                return false;
            }
        }

        return $model;
    }
}
