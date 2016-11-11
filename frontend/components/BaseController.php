<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 8-Mar-16
 * Time: 18:54
 */

namespace frontend\components;

use common\helpers\DBSyncHelper;
use common\models\Client;
use common\models\NotificationSettings;
use common\models\User;
use yii\filters\AccessControl;
use yii\helpers\Url;

class BaseController extends \yii\web\Controller
{
    public $layout = 'main';
    public $client_id;

    /**
     * @var Client
     */
    public $client;

    public $settings;
    public $showColumns = [];
    public $list_view = 'table';

    public function init()
    {
        /* @var $user \common\models\User */
        $user = \Yii::$app->user->identity;
        if ($user) {
            if(!$user->client_id) {
                \Yii::$app->session
                    ->setFlash('error', 'Администратор сервиса не может входить в эту зону');
                \Yii::$app->user->logout();
            }


            $this->client_id = $user->client_id;

//            \Yii::$app->user->logout();

            $this->client = Client::findOne($this->client_id);
            if (empty($this->client) || !$this->client->is_active) {
                $this->layout = 'client-disabled';
                return '';
            }


            $this->settings = NotificationSettings::findOne(['client_id' => $this->client_id]);
            if (!$this->settings) {
                $this->settings = new NotificationSettings([
                    'client_id' => $this->client_id, 'low_products' => 20,
                    'show_article' => 1, 'show_barcode' => 1, 'show_code_client' => 1
                ]);
                $this->settings->save();
            }
            if ($this->settings->show_article) {
                $this->showColumns[] = 'article';
            }
            if ($this->settings->show_barcode) {
                $this->showColumns[] = 'barcode';
            }
            if ($this->settings->show_code_client) {
                $this->showColumns[] = 'code_client';
            }
            if (!empty($_POST['list_view'])) {
                $this->list_view = \Yii::$app->request->post('list_view');
            }else if (!$this->list_view = \Yii::$app->session->get('list_view')){
                $this->list_view = 'table';
            }
            \Yii::$app->session->set('list_view', $this->list_view);
        }


        parent::init();
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'logout', 'update', 'create', 'login', 'view','product','order','profile','user','payments'],
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],

                    // Разрешаем доступ нужным пользователям.
                    [
                        'allow' => true,
                        'roles' => ['clientAdmin', 'clientManager', 'serviceAdmin'],
                        //'roles' => ['@']
                        'actions' => ['index', 'logout', 'update', 'create', 'login', 'view','product','order','profile','user','payments'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['profile']
                    ]
                ]
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
}