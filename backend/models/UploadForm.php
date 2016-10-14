<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 28-мар-16
 * Time: 06:18
 */

namespace backend\models;


use common\helpers\CSVSyncHelper;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $csvProductsFile;
    public $csvOrdersFile;

    public function rules()
    {
        return [
            [['csvProductsFile', 'csvOrdersFile'], 'safe'],
            [['csvProductsFile', 'csvOrdersFile'], 'file', 'skipOnEmpty' => true],
        ];
    }

    public function process()
    {
        if ($this->validate()) {
            if ($this->csvProductsFile) {
                $contentProducts = file_get_contents(
                    $this->csvProductsFile->tempName
                );
                CSVSyncHelper::importCSVProducts($contentProducts);
            }

            if ($this->csvOrdersFile) {
                $contentOrders = file_get_contents($this->csvOrdersFile->tempName);
                CSVSyncHelper::importCSVOrders($contentOrders);
            }

            return true;
        } else {
            return false;
        }
    }
}
