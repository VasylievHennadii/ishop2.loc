<?php 

namespace app\controllers\admin;

use app\models\User;

/**
 * контроллер для регистрации и входа в аккаунт Admin
 */
class UserController extends AppController {

    /**
     * метод Action для авторизации Admin
     */
    public function loginAdminAction(){
        if(!empty($_POST)){
            $user = new User();
            if(!$user->login(true)){              
                $_SESSION['error'] = 'Логин/пароль введены неверно Admin';
            }
            if(User::isAdmin()){
                redirect(ADMIN);
            }else{
                redirect();
            }
        }
        $this->layout = 'login';
    }

}





?>