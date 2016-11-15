<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 8-Mar-16
 * Time: 18:54
 */

namespace backend\components;

use common\helpers\DBSyncHelper;
use common\models\User;
use yii\filters\AccessControl;

class BaseController extends \yii\web\Controller
{
    public $layout = 'main';
    public $list_view = 'table';

    public function init()
    {
        if (!empty($_POST['list_view'])) {
            $this->list_view = \Yii::$app->request->post('list_view');
        }else if (!$this->list_view = \Yii::$app->session->get('list_view')){
            $this->list_view = 'table';
        }
        \Yii::$app->session->set('list_view', $this->list_view);
        parent::init();
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update', 'create', 'login', 'view','product','order','profile','user','payments','gii'],
                'rules' =>[
                    [
                        'actions' => [ 'login' ],
                        'allow'   => true,
                        'roles'   => [ '?' ],
                    ],

                    // Разрешаем доступ нужным пользователям.
                    [
                        'allow' => true,
                        'roles' => ['serviceAdmin', 'serviceManager'],
                        //'roles' => ['@']
                        'actions' => ['index', 'update', 'create', 'login', 'view','product','order','profile','user','payments','gii'],
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
}