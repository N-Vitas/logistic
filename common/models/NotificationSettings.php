<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notification_settings".
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $low_products
 * @property string $emails
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property integer $client_notification
 * @property integer $client_complete_notification
 *
 * @property integer $show_article
 * @property integer $show_barcode
 * @property integer $show_code_client
 */
class NotificationSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'low_products'], 'required'],
            ['low_products', 'default', 'value' => 20],
            [['client_id', 'low_products', 'client_notification', 'client_complete_notification'], 'integer'],
            [['emails'], 'string'],
            [['name', 'address', 'phone', 'email'], 'safe'],
            [['show_article', 'show_barcode', 'show_code_client'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Клиент',
            'low_products' => 'Предел остатков, при котором высылать оповещение',
            'emails' => 'Электронные адреса, на которые высылать оповещение (через запятую)',
            'client_notification' => 'Высылать оповещение при отправке товара клиенту',
            'client_complete_notification' => 'Высылать оповещение при получении товара клиентом',
            'name' => 'Название компании',
            'address' => 'Адрес компании',
            'phone' => 'Телефон компании',
            'email' => 'E-mail компании',
            'show_article' => 'Артикуль',
            'show_barcode' => 'Штрих-код',
            'show_code_client' => 'Код клиента'
        ];
    }

    public static function initClient($client_id)
    {
        $model = NotificationSettings::findOne(['client_id' => $client_id]);

        if (!$model) {
            $model = new NotificationSettings(['client_id' => $client_id, 'low_products' => 20]);
            $model->save();
        }

        return $model;
    }
}
