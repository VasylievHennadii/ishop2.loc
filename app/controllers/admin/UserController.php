<?php 

namespace app\controllers\admin;

use app\models\User;
use ishop\libs\Pagination;

/**
 * контроллер для регистрации и входа в аккаунт Admin
 */
class UserController extends AppController {

    public function indexAction(){
        //реализация пагинации для вывода users
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 3;
        $count = \R::count('user');
        $pagination = new Pagination($page, $perpage, $count);
        $start = $pagination->getStart();

        $users = \R::findAll('user', "LIMIT $start, $perpage");
        $this->setMeta('Список пользователей');
        $this->set(compact('users', 'pagination', 'count'));
    }


    /**
     * метод для редактирования пользователей
     */
    public function editAction(){
        $user_id = $this->getRequestID();
        $user = \R::load('user', $user_id);
        $this->setMeta('Редактирование профиля пользователя ' . "{$user->name}");
        $this->set(compact('user'));
    }


    /**
     * метод Action для авторизации пользователей в Admin
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