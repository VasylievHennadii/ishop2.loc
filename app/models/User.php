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

}




?>