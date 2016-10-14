<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_log".
 *
 * @property integer $id
 * @property string $created_at
 * @property integer $order_id
 * @property integer $status
 * @property string $status_date
 * @property Order $order
 */
class OrderLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'status_date'], 'safe'],
            [['order_id', 'status'], 'required'],
            [['order_id', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'order_id' => 'Order ID',
            'status' => 'Status',
            'status_date' => 'Status Date',
        ];
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
