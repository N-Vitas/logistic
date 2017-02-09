<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 9-Mar-16
 * Time: 00:39
 */

namespace backend\models;


class ClientUser extends \common\models\User
{
    public $role;
    public $password;

    public static $roles = [
        'clientAdmin' => 'Администратор',
        'clientManager' => 'Менеджер'
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['role', 'username', 'email'], 'string'],
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
        if ($insert) {
            $this->client_id = \Yii::$app->user->getIdentity()->client_id;
        }
        // if ($this->imageFile) {
        //     $fileName = 'uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
        //     if ($this->imageFile->saveAs($fileName)) {
        //         $this->image = $fileName;
        //     }
        // }
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
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