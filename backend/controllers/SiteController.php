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
            if ($user->load(Yii::$app->request->post())) {
                $file = UploadedFile::getInstance($user, 'imageFile');
                if($file){
                    $basePath = \Yii::getAlias('@frontend/web/upload/').$file->name;
                    $uri = '/upload/'.$file->name;
                    // if(!is_dir($dirPath)){
                    //     var_dump(is_dir($dirPath));die;
                    //     mkdir($dirPath,0777,true);
                    // }
                    move_uploaded_file($file->tempName, $basePath);
                    $user->image = $uri;          
                }
                if($user->save()){
                    // \Yii::$app->session->setFlash('success', 'Профиль успешно обновлен');
                    $this->refresh();
                }
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
