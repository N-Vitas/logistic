<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sync_log".
 *
 * @property integer $id
 * @property string $created_at
 * @property integer $type
 * @property string $log
 * @property integer $errors
 */
class SyncLog extends \yii\db\ActiveRecord
{
    const TYPE_IMPORT_PRODUCTS = 1;
    const TYPE_IMPORT_ORDERS = 2;
    const TYPE_EXPORT = 101;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sync_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['type', 'errors'], 'integer'],
            [['log'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'type' => 'Type',
            'log' => 'Log',
            'errors' => 'Errors',
        ];
    }

    public static function log($type, $updated, $created, $errors)
    {
        $log = new self([
            'created_at' => time(),
            'type' => $type,
            'log' => "Создано: $created, Обновлено: $updated",
            'errors' => $errors,
        ]);
        return $log->save();
    }

    public static function logImportProducts($updated, $created, $errors)
    {
        return self::log(self::TYPE_IMPORT_PRODUCTS, $updated, $created, $errors);
    }

    public static function logImportOrders($updated, $created, $errors)
    {
        return self::log(self::TYPE_IMPORT_ORDERS, $updated, $created, $errors);
    }
}
