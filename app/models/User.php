<?php 

namespace app\models;

/**
 * модель для регистрации и входа в аккаунт
 */
class User extends AppModel{

    /**
     * массив свойств модели
     */
    public $attributes = [
        'login' => '',
        'password' => '',
        'name' => '',
        'email' => '',
        'address' => '',
        'role' => 'user',
    ];

    /**
     * массив правил для валидации
     */
    public $rules = [
        'required' => [
            ['login'],
            ['password'],
            ['name'],
            ['email'],
            ['address'],
        ],
        'email' => [
            ['email'],
        ],
        'lengthMin' => [
            ['password', 6],
        ]
    ];

    /**
     * метод проверки уникальности login и email
     */
    public function checkUnique(){
        $user = \R::findOne('user', 'login = ? OR email = ?', [$this->attributes['login'], $this->attributes['email']]);
        if($user){
            if($user->login == $this->attributes['login']){
                $this->errors['unique'][] = 'Этот логин уже занят';
            }
            if($user->email == $this->attributes['email']){
                $this->errors['unique'][] = 'Этот email уже занят';
            }
            return false;
        }
        return true;
    }

    /**
     * метод для авторизации, как с общей страницы, так и из админки
     */
    public function login($isAdmin = false){
        $login = !empty(trim($_POST['login'])) ? trim($_POST['login']) : null;
        $password = !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;
        if($login && $password){
            if($isAdmin){
                $user = \R::findOne('user', "login = ? AND role = 'admin'", [$login]);
            }else{
                $user = \R::findOne('user', "login = ? ", [$login]);
            }
            if($user){
                if(password_verify($password, $user->password)){
                    foreach($user as $k => $v){
                        if($k != 'password') $_SESSION['user'][$k] = $v;
                    }
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * метод проверяет авторизирован ли пользователь(true - авторизирован)
     */
    public static function checkAuth(){
        return isset($_SESSION['user']);
    } 

    /**
     * проверяем роль пользователя(admin/user)(true - admin)
     */
    public static function isAdmin(){
        return (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin');
    }





}




?>