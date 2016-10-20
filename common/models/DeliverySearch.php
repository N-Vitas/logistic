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

class DeliverySearch extends Order
{
  public $orderStatus;
  public $city;
  public function rules()
  {
      return [
            [['id', 'client_id'], 'integer'],
            [['created_at', 'client_name', 'address', 'phone', 'email', 'orderStatus','payment_type','delivery_date','city'], 'safe'],
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
    return parent::attributeLabels();
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
        'id' => $this->id,
        'client_id' => $client_id ? $client_id : $this->client_id,
    ]);
    if($this->orderStatus != -1){
      $query->andFilterWhere(['status' => $this->orderStatus]);
    }
    if($this->payment_type != -1){
      $query->andFilterWhere(['payment_type' => $this->payment_type]);
    }
    if(!empty($this->city)){
      $city_id = City::find()->where(['like','title',$this->city]);
      if($city_id->count()){
        foreach ($city_id->all() as $model) {          
          $query->andFilterWhere(['city_id' => $model->id]);
        }
      }else
      $query->andFilterWhere(['city_id' => 0]);
    }
    $query->andFilterWhere(['like', 'id', $this->id])
        ->andFilterWhere(['like', 'client_name', $this->client_name])
        ->andFilterWhere(['like', 'created_at', $this->created_at])
        ->andFilterWhere(['like', 'delivery_date', $this->delivery_date])
        ->andFilterWhere(['like', 'address', $this->address])
        ->andFilterWhere(['like', 'phone', $this->phone])
        ->andFilterWhere(['like', 'email', $this->email])
        ->andFilterWhere(['like', 'price', (string)$this->price]);


    return $dataProvider;
  }
}