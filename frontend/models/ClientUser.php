<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 9-Mar-16
 * Time: 00:39
 */

namespace frontend\models;

use common\models\Order;
use yii\data\ActiveDataProvider;


class ClientUser extends \common\models\User
{
    public $imageFile;
    public $role;
    public $password;

    public static $roles = [
        'clientAdmin' => 'Администратор',
        'clientManager' => 'Менеджер'
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['role', 'username', 'email'], 'string'],

        ]);
    }

    public function attributeLabels()
    {

        return array_merge(parent::attributeLabels(), [
            'role' => 'Роль',
            'orderCount' => 'Кол-во оформленных заказов'
        ]);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->client_id = \Yii::$app->user->getIdentity()->client_id;
        }
        if ($this->imageFile) {
            $fileName = 'uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            if ($this->imageFile->saveAs($fileName)) {
                $this->image = $fileName;
            }
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $auth = \Yii::$app->getAuthManager();
            $auth->assign($auth->getRole($this->role), $this->id);
        }

        parent::afterSave($insert, $changedAttributes);
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }

    public function getOrders()
    {
        return self::hasMany(Order::className(), ['user_id' => 'id']);
    }

    public function getOrdersCount($dateFrom = false, $dateTo = false)
    {
        $query = Order::find()
            ->where([
                'client_id' => $this->client_id,
                'status' => Order::STATUS_COMPLETE,
                'user_id' => $this->id
            ]);

        if (!empty($dateFrom)) {
            $query->andWhere(['>=', 'created_at', $dateFrom]);
        }

        if (!empty($dateTo)) {
            $query->andWhere(['<=', 'created_at', $dateTo]);
        }

        return $query->count();
    }
}