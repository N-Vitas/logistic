<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 18-апр-16
 * Time: 04:54
 */

namespace console\controllers;


use yii\console\Controller;
use common\helpers\DBSyncHelper;

class DbSyncController extends Controller
{
    public function actionStart()
    {
        $this->actionImportProducts();
        $this->actionImportOrderStatuses();
        $this->actionExportOrders();
    }

    public function actionImportProducts()
    {
        DBSyncHelper::importProducts();
    }

    public function actionImportOrderStatuses()
    {
        DBSyncHelper::importOrders();
    }

    public function actionExportOrders()
    {
        DBSyncHelper::exportOrders();
    }

    public function actionTest()
    {
        date_default_timezone_set('Asia/Almaty');
        echo date("H").PHP_EOL;
        echo date_default_timezone_get().PHP_EOL;
    }
}