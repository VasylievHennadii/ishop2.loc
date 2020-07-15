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
            //debug($user->attributes);
            if(!$user->validate($data) || !$user->checkUnique()){
                $user->getErrors();
                $_SESSION['form_data'] = $data;                
            }else{
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                if($user->save('user')){
                    $_SESSION['success'] = 'Пользователь зарегистрирован';                   
                }else{
                    $_SESSION['error'] = 'Ошибка регистрации в БД!';
                }                
            }     
            redirect();
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