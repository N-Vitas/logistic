<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 9-Mar-16
 * Time: 01:17
 */

namespace backend\models;

use common\models\User;

class ServiceUser extends User
{
    public $imageFile;
    public $role;

    public static $roles = [
        self::SERVICE_ADMIN_ROLE => 'Администратор сервиса',
        self::SERVICE_MANAGER_ROLE => 'Менеджер сервиса',
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['username', 'email'], 'required'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Минимальная длина пароля - 6 символов'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, bmp, gif'],
            [['imageFile','role'], 'safe'],
            ['passwordCompare', 'compare', 'compareAttribute' => 'password',
                'message' => 'Поле "{attribute}" должно совпадать с полем "{compareValueOrAttribute}"'],

        ]);
    }

    public function attributeLabels()
    {

        return array_merge(parent::attributeLabels(), [
            'role' => 'Роль',
        ]);
    }

    public function beforeSave($insert)
    {
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        // $auth = \Yii::$app->getAuthManager();
        // var_dump($changedAttributes,$this->role,$auth->getRole($this->role));die;
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
}