<?php 

namespace app\controllers;

use app\models\User;

/**
 * контроллер для регистрации и входа в аккаунт User
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
        if(!empty($_POST)){
            $user = new User();
            if($user->login()){
                $_SESSION['success'] = 'Вы успешно авторизованы';
            }else{
                $_SESSION['error'] = 'Логин/пароль введены неверно';
            }
            redirect();
        }
        $this->setMeta('Вход');
    }

    /**
     * Action метод для выхода
     */
    public function logoutAction(){
        if(isset($_SESSION['user'])) unset($_SESSION['user']);
        redirect();
    }

}



?>