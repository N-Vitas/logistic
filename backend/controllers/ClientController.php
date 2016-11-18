<?php

namespace backend\controllers;

use backend\models\ClientUser;
use backend\models\UserSearch;
use common\models\NotificationSettings;
use common\models\Order;
use frontend\models\OrderSearch;
use frontend\models\ProductSearch;
use Yii;
use common\models\Client;
use backend\models\ClientSearch;
use backend\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\Product;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends BaseController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Client model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $clientUsers = new UserSearch();
        $model = $this->findModel($id);
        $dataProvider = $clientUsers->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['client_id' => $model->id]);

        $activeProducts = Product::find()->where(['client_id' => $model->is_id])->count();
        $activeOrders = Order::find()->where(['client_id' => $model->is_id])->count();

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'clientUsers' => $clientUsers,
            'activeProducts' => $activeProducts,
            'activeOrders' => $activeOrders,
        ]);
    }

    public static function getClientColumns($client)
    {
        $columns = [];
        if (!$settings = $client->settings) {
            $settings = new NotificationSettings([
                'client_id' => $client->id, 'low_products' => 20,
                'show_article' => 1, 'show_barcode' => 1, 'show_code_client' => 1
            ]);
            $settings->save();
        }
        if ($settings->show_article) {
            $columns[] = 'article';
        }
        if ($settings->show_barcode) {
            $columns[] = 'barcode';
        }
        if ($settings->show_code_client) {
            $columns[] = 'code_client';
        }

        return $columns;
    }

    /**
     * Отображает остатки на складе по клиенту
     *
     * @param $id ID клиента
     *
     * @return string
     */
    public function actionProducts($id)
    {
        $client = $this->findModel($id);
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['client_id' => $client->is_id]);


        return $this->render('product/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'client' => $client,
            'columns' => self::getClientColumns($client),
        ]);
    }

    public function actionOrders($id)
    {
        $client = $this->findModel($id);

        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $client->is_id);

        // $yesterdayBegin = strtotime(date('Y-m-d') . ' -1 day');
        // $yesterdayEnd = strtotime(date('Y-m-d') . '');
        
        $yesterdayBegin = date('Y-m-d H:i:s',mktime(date("H"), date("i"), date("s"), date("m")  , date("d")-1, date("Y")));
        $yesterdayEnd = date('Y-m-d H:i:s',mktime(date("H"), date("i"), date("s"), date("m")  , date("d"), date("Y")));

        $deliveredYesterday = Order::find()
            ->where(['between', 'delivery_date', $yesterdayBegin, $yesterdayEnd])
            ->andWhere(['client_id' => $client->is_id])
            ->andWhere(['status' => Order::STATUS_COMPLETE])
            ->count();

        $deliveredToday = Order::find()
            ->where(['>', 'delivery_date', $yesterdayEnd])
            ->andWhere(['status' => Order::STATUS_COMPLETE])
            ->count();

        $toDeliver = Order::find()
            ->where(['in', 'status', Order::$activeStatuses])
            ->count();

        return $this->render('order/index', [
            'client' => $client,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'deliveredYesterday' => $deliveredYesterday,
            'deliveredToday' => $deliveredToday,
            'toDeliver' => $toDeliver,
            'columns' => self::getClientColumns($client),
        ]);
    }

    /**
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Client();
        $user = new User(['scenario' => 'create']);

        if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())
            && $model->validate()
        ) {
            if ($model->save()) {
                $user->client_id = $model->id;
                $user->status = User::STATUS_ACTIVE;
                if ($user->save()) {
                    $auth = Yii::$app->authManager;

                    $model->admin_id = $user->id;
                    $model->save(['admin_id']);

                    $serviceAdminRole = $auth->getRole(User::CLIENT_ADMIN_ROLE);
                    $auth->assign($serviceAdminRole, $user->id);

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'user' => $user,
            ]);
        }
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $settingsModel = NotificationSettings::initClient($model->id);

        $haveToReturn = false;

        if ($settingsModel->load(Yii::$app->request->post()) && $settingsModel->save()) {
            $haveToReturn = true;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $haveToReturn = true;
        }

        if ($haveToReturn === true) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'settingsModel' => $settingsModel,
            ]);
        }
    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCreateUser($id)
    {

        $model = new ClientUser(['client_id' => $id, 'scenario' => 'create']);
        $client = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->render('user/create', [
                'model' => $model,
                'client' => $client
            ]);
        }
    }

    public function actionUpdateUser($id, $user_id)
    {
        $model = ClientUser::findOne(['id' => $user_id]);
        $client = $this->findModel($id);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->render('user/update', [
                'model' => $model,
                'client' => $client
            ]);
        }
    }

    public function actionDeleteUser($id, $user_id)
    {
        ClientUser::deleteAll(['id' => $user_id]);

        return $this->redirect(['view', 'id' => $id]);
    }
}
