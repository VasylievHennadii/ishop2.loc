<?php 

namespace app\controllers;

use app\models\User;

/**
 * контроллер для регистрации и входа в аккаунт
 */
class UserController extends AppController {

    /**
     * Action метод для регистрации
     */
    public function signupAction(){
        if(!empty($_POST)){
            $user = new User();
            $data = $_POST;
            $user->load($data);
            debug($user);
            die;
        }
        $this->setMeta('Регистрация');
    }

    /**
     * Action метод для входа
     */
    public function loginAction(){
        
    }

    /**
     * Action метод для выхода
     */
    public function logoutAction(){
        
    }

}



?>