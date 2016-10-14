<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property integer $id
 * @property string $name
 * @property string $legal_name
 * @property string $is_id
 * @property string $created_at
 * @property integer $is_active
 * @property integer $admin_id
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['is_active', 'default', 'value' => 1],
            [['name', 'legal_name', 'is_id'], 'required'],
            [['created_at', 'is_active', 'admin_id'], 'safe'],
            [['name', 'legal_name', 'is_id'], 'string', 'max' => 255],
            [['is_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название в сервисе',
            'legal_name' => 'Юридическое название',
            'is_id' => 'Индитивикатор для связки с ИС "Хранение и доставка"',
            'created_at' => 'Дата регистрации',
            'is_active' => 'Активный клиент',
            'productCount' => 'Товаров на хранении',
            'activeOrders' => 'Заказов в работе',
            'admin.username' => 'Администратор клиента'
        ];
    }

    public function getAdmin()
    {
        return $this->hasOne(User::className(), ['id' => 'admin_id']);
    }

    public function getSettings()
    {
        return $this->hasOne(NotificationSettings::className(), ['client_id' => 'id']);
    }
}
