<?php
namespace backend\controllers;

use backend\components\BaseController;
use backend\models\ServiceUser;
use backend\models\UploadForm;
use common\helpers\CSVSyncHelper;
use common\helpers\SyncHelper;
use Yii;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'profile', 'export-orders'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->csvProductsFile =
                UploadedFile::getInstance($model, 'csvProductsFile');
            $model->csvOrdersFile =
                UploadedFile::getInstance($model, 'csvOrdersFile');
            if ($model->process()) {
                // file is uploaded successfully
                \Yii::$app->session->setFlash('success', 'Синхронизировано!');
            } else {
                \Yii::$app->session->setFlash('danger', 'Ошибка! Попробуйте позже');
            }
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionLogin()
    {
        $this->layout = 'main-login';

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionProfile()
    {
        /** @var $user ServiceUser */

        $user_id = \Yii::$app->user->id;
        $user = ServiceUser::findOne($user_id);

        if (Yii::$app->request->isPost) {
            $user->imageFile = UploadedFile::getInstance($user, 'imageFile');

            if ($user->load(Yii::$app->request->post()) && $user->save()) {
                \Yii::$app->session->setFlash('success', 'Профиль успешно обновлен');
            }
        }
        return $this->render('@backend/views/user/profile', [
            'model' => $user,
        ]);
    }

    public function actionExportOrders()
    {
        CSVSyncHelper::exportCSVOrders();
//        echo 'ok';
    }
}
