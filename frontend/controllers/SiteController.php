<?php
namespace frontend\controllers;

use common\models\Order;
use common\models\User;
use frontend\components\BaseController;
use frontend\models\ClientUser;
use frontend\models\OrderSearch;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
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
        return array_merge(parent::actions(),[
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchToDeliver = new OrderSearch(['status' => Order::STATUS_DELIVERING]);
        $toDeliverProvider = $searchToDeliver
            ->search(Yii::$app->request->queryParams);
        $toDeliverProvider->query->andWhere(['status' => Order::STATUS_DELIVERING]);

        $searchDelivered = new OrderSearch();
        $deliveredProvider = $searchDelivered
            ->search(Yii::$app->request->queryParams);
        $deliveredProvider->query->andWhere(['status' => Order::STATUS_COMPLETE]);

        return $this->render('index', [
            'searchToDeliver' => $searchToDeliver,
            'toDeliverProvider' => $toDeliverProvider,
            'searchDelivered' => $searchDelivered,
            'deliveredProvider' => $deliveredProvider,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
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

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'main-login';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionProfile()
    {
        /** @var $user ClientUser */

        $user_id = \Yii::$app->user->id;
        $user = ClientUser::findOne($user_id);

        if (Yii::$app->request->isPost) {
            if ($user->load(Yii::$app->request->post())) {
                $user->imageFile = UploadedFile::getInstance($user, 'imageFile');
                if($user->imageFile){
                    $basePath = \Yii::getAlias('@frontend/web/upload/').$user->imageFile->name;
                    $uri = '/upload/'.$user->imageFile->name;
                    // if(!is_dir($dirPath)){
                    //     var_dump(is_dir($dirPath));die;
                    //     mkdir($dirPath,0777,true);
                    // }
                    move_uploaded_file($user->imageFile->tempName, $basePath);
                    $user->image = $uri;          
                }
                if($user->save()){   
                    \Yii::$app->session->setFlash('success', 'Профиль успешно обновлен');
                    $this->refresh();
                }
            }
        }
        return $this->render('@frontend/views/user/profile', [
            'model' => $user,
        ]);
    }

//      public function actionCreate()
//     {
        
//         file_put_contents(\Yii::getAlias('@frontend/web').'/upload/filelog.log', json_encode($_FILES,JSON_UNESCAPED_UNICODE));
//         file_put_contents(\Yii::getAlias('@frontend/web').'/upload/somelog.log', json_encode($_POST,JSON_UNESCAPED_UNICODE));
//         $model = new Images();
//         if (Yii::$app->request->isPost) {
//             $model->file = UploadedFile::getInstance($model, 'file');
//             if ($model->file) {
//                 $model->parent_user_id = Yii::$app->request->post("parent_user_id");
//                 $model->category = Yii::$app->request->post("category");
//                 $model->title = preg_replace('/[.jpg|.png|.jpeg|.gif]/', '',$model->file->name);
//                 $array = explode(".",$model->file->name);
//                 $model->type = mb_strtolower($array[(count($array)-1)]);

//                 $model->size = $model->file->size;
//                 if($model->save()){
//                     switch (Yii::$app->request->post("category")) {
//                         case 'avatar':
//                             $profile = Profile::find()->where(['user_id'=>Yii::$app->request->post("parent_user_id")])->one();
//                             $profile->gravatar_id = md5(time());
//                             $profile->save();
//                             return ['id'=>$model->id];
//                             break;
//                             // Lj70zf37gG
//                         case 'cover':
//                             $profile = Profile::find()->where(['user_id'=>Yii::$app->request->post("parent_user_id")])->one();
// $basePath = \Yii::getAlias("@images-url");                          
// $image = 'http://'.$basePath.'/avatar/'.Yii::$app->request->post("parent_user_id").'_cover.jpg?'.time();
//                             $profile->background = $image;
//                             $profile->save();
//                             return ['id'=>$model->id,'image'=>$image];
//                             break;
//                         case 'post':
//                             $post = Post::find()->where(["id"=>Yii::$app->request->post("post_id")])->one();
//                             $basePath = \Yii::getAlias("@images-url");
//                             $number = sprintf('%08d', $model->id);
//                             $image = 'http://'.$basePath.'/'.substr($number, 0, 3).'/'.substr($number, 3, 3).'/'.$number.'.'.str_replace('image/','',$model->type);
//                             //var_dump($image);die;
//                             $imagedata = json_decode($post->data,true);
//                             if(isset($imagedata["images"])){
//                                 array_push($imagedata["images"],$image);
//                             }
//                             else{
//                                 $imagedata['images'][] = $image;
//                             }
//                             $post->data = json_encode($imagedata,JSON_UNESCAPED_UNICODE);
//                             if($post->save())
//                                 return true;
//                             else
//                                 return $post->errors();                          
//                             break;

//                         case 'carsfirst':
//                             $car = Car::find()->where(["id"=>Yii::$app->request->post("post_id")])->one();
//                             $basePath = \Yii::getAlias("@images-url");
//                             $number = sprintf('%08d', $model->id);
//                             $image = 'http://'.$basePath.'/garage/landing/'.substr($number, 0, 3).'/'.substr($number, 3, 3).'/'.$number.'.'.str_replace('image/','',$model->type);
//                             $car->firstimages = $image;
//                             if($car->save())
//                                 return true;
//                             else
//                                 return $car->errors();                          
//                             break;

//                         case 'carslast':
//                             $car = Car::find()->where(["id"=>Yii::$app->request->post("post_id")])->one();
//                             $basePath = \Yii::getAlias("@images-url");
//                             $number = sprintf('%08d', $model->id);
//                             $image = 'http://'.$basePath.'/garage/custom/'.substr($number, 0, 3).'/'.substr($number, 3, 3).'/'.$number.'.'.str_replace('image/','',$model->type);
//                             //var_dump($image);die;
//                             $imagedata = json_decode($car->lasttimages,true);
//                             // if(isset($imagedata)){
//                                 // array_push($imagedata,$image);
//                             // }
//                             // else{
//                                 $imagedata[] = $image;
//                             // }
//                             $car->lasttimages = json_encode($imagedata,JSON_UNESCAPED_UNICODE);
//                             if($car->save())
//                                 return true;
//                             else
//                                 return $car->errors();                          
//                             break;
//                     }
//                 } else {                    
//                     return $model->errors;
//                 }
//             } else {
//                 return $model->errors;
//             }
//         }   
//     }
}
