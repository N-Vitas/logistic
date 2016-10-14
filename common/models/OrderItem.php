<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $order_id
 * @property integer $quantity
 * @property integer $price
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'order_id', 'price'], 'required'],
            [['item_id', 'order_id', 'quantity', 'price'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'order_id' => 'Order ID',
            'quantity' => 'Quantity',
            'price' => 'Price',
        ];
    }

    public function getProduct()
    {
        return self::hasOne(Product::className(), ['id' => 'item_id']);
    }
}
