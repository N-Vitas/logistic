<?php

namespace frontend\controllers;

use Yii;
use common\models\NotificationSettings;
use yii\data\ActiveDataProvider;
use frontend\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NotificationsController implements the CRUD actions for NotificationSettings model.
 */
class NotificationsController extends BaseController
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
     * Lists all NotificationSettings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = NotificationSettings::initClient($this->client_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Настройки сохранены!');
        }
        return $this->render('create', [
            'model' => $model,
            'client' => $this->client
        ]);
    }

    /**
     * Finds the NotificationSettings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NotificationSettings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NotificationSettings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
