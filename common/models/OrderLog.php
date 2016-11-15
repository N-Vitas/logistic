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
            [['order_id', 'status','status_payments'], 'required'],
            [['order_id', 'status','status_payments'], 'integer']
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
            'status_payments' => 'Status Payments'
        ];
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
