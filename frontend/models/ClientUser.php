<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 9-Mar-16
 * Time: 00:39
 */

namespace frontend\models;

use common\models\Order;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class ClientUser extends \common\models\User
{
    public $imageFile;
    public $role;
    public $password;
    public $dateFrom;
    public $dateTo;
    public $NewOrdersCount;
    public $WorkOrdersCount;
    public $CompleteOrdersCount;

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
            [['username', 'email'], 'unique'],
            [['role', 'username', 'email'], 'string'],
            [['username', 'email'], 'required'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Минимальная длина пароля - 6 символов'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['imageFile','dateFrom','dateTo'], 'safe'],
            ['passwordCompare', 'compare', 'compareAttribute' => 'password',
                'message' => 'Поле "{attribute}" должно совпадать с полем "{compareValueOrAttribute}"'],

        ]);
    }

    public function attributeLabels()
    {

        return array_merge(parent::attributeLabels(), [
            'role' => 'Роль',
            'newOrderCount' => 'Кол-во оформленных заказов',
            'workOrderCount' => 'Кол-во заказов в работе',
            'completeOrderCount' => 'Кол-во завершенных заказов',
            'dateFrom' => 'a',
            'dateTo' => 'b',
        ]);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->client_id = \Yii::$app->user->getIdentity()->client_id;
        }
        // if ($this->imageFile) {
        //     $fileName = 'uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
        //     if ($this->imageFile->saveAs($fileName)) {
        //         $this->image = $fileName;
        //     }
        // }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $auth = \Yii::$app->getAuthManager();
            $auth->assign($auth->getRole($this->role), $this->id);
        }else{            
            $auth = \Yii::$app->getAuthManager();
            $item = $auth->getRole($this->role);
            $item = $item ? : $auth->getPermission($this->role);
            $auth->revokeAll($this->id);            
            $auth->assign($auth->getRole($this->role), $this->id);
        }

        parent::afterSave($insert, $changedAttributes);
    }
    
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($client_id,$params)
    {
        $query = self::find()->where(['user.client_id' => $client_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ]
        ]);

        if (!$this->load($params)) {
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

    public function getNewOrdersCount()
    {
        $params = \Yii::$app->request->getQueryParams();// || ['ClientUser'=>['dateFrom'=>'','dateTo'=>'']];         
        $query = Order::find()
            ->where([
                'client_id' => $this->client->is_id,
                'status' => Order::STATUS_NEW,
                'user_id' => $this->id
            ]);
        if (!empty($params['ClientUser']['dateFrom'])) {
            $query->andWhere(['>=', 'created_at', $params['ClientUser']['dateFrom']]);
        }

        if (!empty($params['ClientUser']['dateTo'])) {
            $query->andWhere(['<=', 'created_at', $params['ClientUser']['dateTo']]);
        }

        return $query->count();
    }

    public function getWorkOrdersCount()
    {
        $params = \Yii::$app->request->getQueryParams('ClientUser');// || ['ClientUser'=>['dateFrom'=>'','dateTo'=>'']]; 
        $query = Order::find()
            ->where([
                'client_id' => $this->client->is_id,
                'status' => Order::STATUS_FILLED,
                'user_id' => $this->id
            ]);
        if (!empty($params['ClientUser']['dateFrom'])) {
            $query->andWhere(['>=', 'created_at', $params['ClientUser']['dateFrom']]);
        }

        if (!empty($params['ClientUser']['dateTo'])) {
            $query->andWhere(['<=', 'created_at', $params['ClientUser']['dateTo']]);
        }

        return $query->count();
    }

    public function getCompleteOrdersCount()
    {
        $params = \Yii::$app->request->getQueryParams('ClientUser');// || ['ClientUser'=>['dateFrom'=>'','dateTo'=>'']]; 
        $query = Order::find()
            ->where([
                'client_id' => $this->client->is_id,
                'user_id' => $this->id
            ])->andWhere(['in','status',[Order::STATUS_CANCELED,Order::STATUS_COMPLETE]]);
        if (!empty($params['ClientUser']['dateFrom'])) {
            $query->andWhere(['>=', 'created_at', $params['ClientUser']['dateFrom']]);
        }

        if (!empty($params['ClientUser']['dateTo'])) {
            $query->andWhere(['<=', 'created_at', $params['ClientUser']['dateTo']]);
        }

        return $query->count();
    }
}