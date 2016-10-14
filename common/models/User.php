<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property string $image
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $client_id
 * @property string $password write-only password
 * @property Client $client
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @var UploadedFile
     */

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public static $statuses = [
        self::STATUS_ACTIVE => 'Активный',
        self::STATUS_DELETED => 'Выключен',
    ];

    const SERVICE_ADMIN_ROLE = 'serviceAdmin';
    const CLIENT_ADMIN_ROLE = 'clientAdmin';
    const SERVICE_MANAGER_ROLE = 'serviceManager';
    const CLIENT_MANAGER_ROLE = 'clientManager';

    public $password;
    public $passwordCompare;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['password', 'required', 'on' => 'create'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Минимальная длина пароля - 6 символов'],
            [['username', 'email'], 'unique'],
            [['username', 'email'], 'required'],
            ['email', 'email'],
            ['image', 'safe'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['auth_key', 'password_hash', 'password_reset_token', 'password'], 'safe'],
            ['passwordCompare', 'compare', 'compareAttribute' => 'password',
                'message' => 'Поле "{attribute}" должно совпадать с полем "{compareValueOrAttribute}"'],
        ];
    }

    public function attributeLabels()
    {

        return [
            'username' => 'Имя пользователя',
            'password' => 'Новый пароль',
            'passwordCompare' => 'Повторите пароль',
            'status' => 'Статус',
            'image' => 'Аватар',
            'imageFile' => 'Аватар',
            'email' => 'E-mail',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
        ]; // TODO: Change the autogenerated stub
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getUserRoles()
    {
        $roles = \Yii::$app->authManager->getRolesByUser($this->id);

        if (!empty($roles['serviceAdmin'])) {
            return 'Администратор сервиса';
        } elseif (!empty($roles['serviceManager'])) {
            return 'Менеджер сервиса';
        } elseif (!empty($roles['clientAdmin'])) {
            return 'Администратор';
        } elseif (!empty($roles['clientManager'])) {
            return 'Менеджер';
        }

        return 'Выключен';
    }

    public function beforeSave($insert)
    {
        if($this->password) {
            $this->setPassword($this->password);
        }


        if($insert) {
            $this->generateAuthKey();
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}
