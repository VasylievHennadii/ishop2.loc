<?php 

namespace app\controllers\admin;

use app\models\AppModel;
use app\models\User;
use ishop\base\Controller;

/**
 * контроллер приложения для Admin
 */
class AppController extends Controller {

    public $layout = 'admin';

    public function __construct($route){
        parent::__construct($route);
        if(!User::isAdmin() && $route['action'] != 'login-admin'){
            redirect(ADMIN . '/user/login-admin');//обращение будет в таком виде UserController::loginAdminAction
        }
        new AppModel();
    }

}

?>