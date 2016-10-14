<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 8-Mar-16
 * Time: 21:50
 */

namespace console\controllers;


use common\models\User;
use yii\console\Controller;
use Yii;

class UserController extends Controller
{
    /**
     * @var $auth \yii\rbac\ManagerInterface
     */
    public $auth;

    public function init()
    {
        $this->auth = Yii::$app->authManager;
    }

    public function actionInitAdmin($username = "admin", $password = "12435hello")
    {
        $user = new User();
        $user->username = $username;
        $user->email = "{$username}@logistic.kz";
        $user->setPassword($password);
        $user->generateAuthKey();

        if ($user->save()) {
            $serviceAdminRole = $this->auth->getRole('serviceAdmin');
            $this->auth->assign($serviceAdminRole, $user->id);

            return true;
        }

        return null;
    }

    public function actionRbac()
    {
        $this->actionUsersRbac();
    }

    public function actionUsersRbac()
    {
        $createServiceAdmin = $this->auth->createPermission('createServiceAdmin');
        $createServiceAdmin->description = 'Create an admin user of whole service';
        $this->auth->add($createServiceAdmin);

        $createClientAdmin = $this->auth->createPermission('createClientAdmin');
        $createClientAdmin->description = 'Create an admin user for client';
        $this->auth->add($createClientAdmin);

        $createServiceManager = $this->auth->createPermission('createServiceManager');
        $createServiceManager->description = 'Create manager user for service';
        $this->auth->add($createServiceManager);

        $createClientManager = $this->auth->createPermission('createClientManager');
        $createClientManager->description = 'Create manager user for client';
        $this->auth->add($createClientManager);

        $serviceAdmin = $this->auth->createRole('serviceAdmin');
        $this->auth->add($serviceAdmin);
        $this->auth->addChild($serviceAdmin, $createServiceAdmin);
        $this->auth->addChild($serviceAdmin, $createClientAdmin);
        $this->auth->addChild($serviceAdmin, $createServiceManager);
        $this->auth->addChild($serviceAdmin, $createClientManager);

        $clientAdmin = $this->auth->createRole('clientAdmin');
        $this->auth->add($clientAdmin);
        $this->auth->addChild($clientAdmin, $createClientManager);

        $serviceManager = $this->auth->createRole('serviceManager');
        $this->auth->add($serviceManager);
        $this->auth->addChild($serviceManager, $createClientAdmin);
        $this->auth->addChild($serviceManager, $createClientManager);

        $clientManager = $this->auth->createRole('clientManager');
        $this->auth->add($clientManager);
    }


}