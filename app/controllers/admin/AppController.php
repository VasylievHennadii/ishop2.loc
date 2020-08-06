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

    /**
     * метод получает id из массива GET или POST;
     * по умолчанию берется id (метод может брать любой другой параметр) из GET(или из POST)
     */
    public function getRequestID($get = true, $id = 'id'){
        if($get){
            $data = $_GET;
        }else{
            $data = $_POST;
        } 
        $id = !empty($data[$id]) ? (int)$data[$id] : null;
        if(!$id){
            throw new \Exception('Страница не найдена', 404);
        }
        return $id;
    }

}

?>