<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 3-мая-16
 * Time: 02:08
 */

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

class SearchAnalitic extends Order
{
  public $orderStatus;
  public $paymentStatus;
  public $city;
  public $filter = 'title';
  public $date_from;
  public $date_to;
  public $product_id;
  public $products;
  public function rules()
  {
      return [
            [['id', 'client_id'], 'integer'],
            [['products','product_id','created_at', 'date_from','date_to','client_name', 'address', 'phone', 'email', 'orderStatus','payment_type','delivery_date','city','filter','paymentStatus'], 'safe'],
            [['price'], 'number'],
        ];
  }
  /** Атрибуты
   * id             Номер заказа
   * created_at     Дата создания
   * client_id      ID клиента
   * client_name    ФИО получателя
   * address        Адрес доставки
   * phone          Телефон получателя
   * product_id     Продукт
   * email          E-mail получателя
   * payment_type   Вид платежа
   * paymentType    Вид платежа
   * product_count  Кол-во продуктов
   * price          Сумма заказа
   * delivery_date  Дата изменения статуса
   * status         Статус
   * city_id        Город доставки
   * city           Город доставки
   * orderStatus    Статус заказа
   * orderCount     Кол-во доставок
   * comment        Комментарий к заказу
   * no_shipping    Самовывоз
   */
  public function attributeLabels()
  {
    return array_merge(parent::attributeLabels(),[
      'date_from' => 'Выбор перриода',
      'filter' => 'Фильтр продукта',
    ]);
  }

  public function scenarios()
  {
      // bypass scenarios() implementation in the parent class
      return Model::scenarios();
  }

  public function search($client_id, $params) {

    $query = Order::find()->where(['client_id' => $client_id]);
    // собираем масив датапровайдера
    $dataProvider = new ActiveDataProvider([
      'query' => $query, // конечный запрос в базу за данными
      // Лимит постраничной навигации
      'pagination' => [
        'pagesize' => 10,
      ],
      // сортировака по полям
      'sort' => [
        'defaultOrder' => ['created_at' => SORT_DESC], // сортировка по умолчанию
        'attributes' => [
          'id',
          'created_at',
          'city' => [
            'asc' => ['city_id' => SORT_ASC],
            'desc' => ['city_id' => SORT_DESC],
          ],
          'address',
          'client_name',
          'phone',
          'paymentType' => [
            'asc' => ['payment_type' => SORT_ASC],
            'desc' => ['payment_type' => SORT_DESC],
          ],
          'price',
          'orderStatus' => [
            'asc' => ['status' => SORT_ASC],
            'desc' => ['status' => SORT_DESC],
          ],
          'paymentStatus' => [
            'asc' => ['status_payments' => SORT_ASC],
            'desc' => ['status_payments' => SORT_DESC],
          ],
          'delivery_date',
        ],
    ],
    ]);
    $this->load($params);

    if (!$this->validate()) {
        // uncomment the following line if you do not want to return any records when validation fails
        // $query->where('0=1');
        return $dataProvider;
    }
    $query->andFilterWhere([
        'orders.id' => $this->id,
        'orders.client_id' => $client_id ? $client_id : $this->client_id,
    ]);
    if(is_array($this->product_id) && count($this->product_id)){
      $query->joinWith('items')->andWhere(['IN', 'order_item.item_id', $this->product_id]);
    }
    if(!empty($this->date_to) && !empty($this->date_from)){
      $query->andFilterWhere(['between', 'orders.created_at', $this->date_from, $this->date_to]);      
    }
    if($this->orderStatus != -1){
      $query->andFilterWhere(['orders.status' => $this->orderStatus]);
    }
    if($this->paymentStatus != -1){
      $query->andFilterWhere(['orders.status_payments' => $this->paymentStatus]);
    }


    if($this->payment_type != -1){
      $query->andFilterWhere(['orders.payment_type' => $this->payment_type]);
    }
    if(!empty($this->city)){
      $city_id = City::find()->where(['like','title',$this->city]);
      if($city_id->count()){
        foreach ($city_id->all() as $model) {          
          $query->andFilterWhere(['orders.city_id' => $model->id]);
        }
      }else
      $query->andFilterWhere(['orders.city_id' => 0]);
    }
    $query->andFilterWhere(['like', 'id', $this->id])
        ->andFilterWhere(['like', 'orders.client_name', $this->client_name])
        ->andFilterWhere(['like', 'orders.created_at', $this->created_at])
        ->andFilterWhere(['like', 'orders.delivery_date', $this->delivery_date])
        ->andFilterWhere(['like', 'orders.address', $this->address])
        ->andFilterWhere(['like', 'orders.phone', $this->phone])
        ->andFilterWhere(['like', 'orders.email', $this->email])
        ->andFilterWhere(['like', 'orders.price', (string)$this->price]);


    return $dataProvider;
  }
}