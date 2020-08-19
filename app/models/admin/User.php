<?php  

namespace app\models\admin;


/**
 * модель для входа аккаунт из Админ панели
 */
class User extends \app\models\User {

    /**
     * массив свойств модели
     */
    public $attributes = [
        'id' => '',
        'login' => '',
        'password' => '',
        'name' => '',
        'email' => '',
        'address' => '',
        'role' => '',
    ];

    /**
     * массив правил для валидации
     */
    public $rules = [
        'required' => [
            ['login'],           
            ['name'],
            ['email'],  
            ['role'],         
        ],
        'email' => [
            ['email'],
        ],        
    ];

    /**
     * метод проверки уникальности login и email
     */
    public function checkUnique(){
        $user = \R::findOne('user', '(login = ? OR email = ?) AND id <> ?', [$this->attributes['login'], $this->attributes['email'], $this->attributes['id']]);
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


}







?>