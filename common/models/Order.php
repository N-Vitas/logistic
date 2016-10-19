<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property \common\models\Product $product
 * @property integer $id
 * @property string $created_at
 * @property integer $client_id
 * @property string $client_name
 * @property string $address
 * @property string $phone
 * @property integer $product_id
 * @property string $email
 * @property string $payment_type
 * @property double $price
 * @property integer $no_shipping
 * @property string $comment
 * @property integer $status
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_FILLED = 1;
    const STATUS_DELIVERING = 2;
    const STATUS_COMPLETE = 3;
    const STATUS_CANCELED = 4;
    const STATUS_DEFAULT = -1;

    public static $statuses = [
        self::STATUS_DEFAULT => 'Выберите статус',
        self::STATUS_NEW => 'На оформлении',
        self::STATUS_FILLED => 'Оформлен',
        self::STATUS_DELIVERING => 'Отправлен',
        self::STATUS_COMPLETE => 'Получен',
        self::STATUS_CANCELED => 'Отменен',
    ];
    public static $statusClasses = [
        self::STATUS_NEW => 'info',
        self::STATUS_FILLED => 'primary',
        self::STATUS_DELIVERING => 'warning',
        self::STATUS_COMPLETE => 'success',
        self::STATUS_CANCELED => 'danger',
    ];

    public static $activeStatuses = [
        self::STATUS_NEW => 'На оформлении',
        self::STATUS_FILLED => 'Оформлен',
        self::STATUS_DELIVERING => 'Отправлен',
    ];

    public static $paymentTypes = [
        -1 => 'Выберите платеж',
        0 => 'Наложенный платеж',
        1 => 'Не получать платеж'
    ];

    public static $cities = [
        'Алматы',
        'Астана',
        'Караганда',
        'Павлодар',
        'Шымкент',
        'Костанай',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'client_name', 'phone', 'email', 'payment_type', 'price'], 'required'],
            [['created_at', 'comment'], 'safe'],
            [
                ['address', 'city_id'],
                'required',
                'when' => function ($model) {
                    return $model->no_shipping;
                },
                'whenClient' => "function (attribute, value) {
                    return !$('#order-no_shipping').is(\":checked\");
                }"
            ],
            [['address', 'city_id'], 'safe'],
            [['id','client_id', 'status', 'city_id'], 'integer'],
            [['price'], 'number'],
            [
                [
                    'client_name', 'address', 'phone', 'email',
                    'payment_type', 'delivery_date'
                ], 'string', 'max' => 255
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер заказа',
            'created_at' => 'Дата создания',
            'client_id' => 'ID клиента',
            'client_name' => 'ФИО получателя',
            'address' => 'Адрес доставки',
            'phone' => 'Телефон получателя',
            'product_id' => 'Продукт',
            'email' => 'E-mail получателя',
            'payment_type' => 'Вид платежа',
            'paymentType' => 'Вид платежа',
            'product_count' => 'Кол-во продуктов',
            'price' => 'Сумма заказа',
            'delivery_date' => 'Дата изменения статуса',
            'status' => 'Статус',
            'city_id' => 'Город доставки',
            'city' => 'Город доставки',
            'orderStatus' => 'Статус заказа',
            'orderCount' => 'Кол-во доставок',
            'comment' => 'Комментарий к заказу',
            'no_shipping' => 'Самовывоз',
        ];
    }

    /**
     * Список доступных товаров для CRUD
     *
     * @return array of \common\models\Product
     */
    public static function getAvailableProducts()
    {
        $result = [];
        $products = Product::find()->where(['>', 'balance', 0])
            ->all();
        foreach ($products as $product) {
            $result[$product->id] = "{$product->title} ({$product->balance})";
        }
        return $result;
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
    }

    public function getItems()
    {
        return self::hasMany(OrderItem::className(), ['order_id' => 'id']);
    }


    public function getCity()
    {
        return self::hasOne(City::className(), ['id' => 'city_id']);
    }

    public function getPaymentType()
    {
//        echo $this->payment_type; die;
        if (is_string($this->payment_type))
            $this->payment_type = intval($this->payment_type);
        return self::$paymentTypes[$this->payment_type];
    }

    public function getOrderStatus($html = true)
    {
        return ($html ? '<span class="label label-' . self::$statusClasses[$this->status] . '">' : "")
        . self::$statuses[$this->status] . ($html ? '</span>' : ' ');
    }

    public function beforeValidate()
    {
        if ($this->no_shipping) {
            $this->scenario = 'no_shipping';
        }

        return parent::beforeValidate();
    }
}
