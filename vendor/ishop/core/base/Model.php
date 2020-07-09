<?php

namespace ishop\base;

use ishop\Db;

/**
 * класс отвечает за работу с данными,
 * в первую очередь с Базой Данных, 
 * но ещё и валидация и обработка данных для функций и т.д.
 */
abstract class Model {

    /**
     * свойство хранит массив свойств модели (модель User), который идентичен полям в таблице БД
     */
    public $attributes = []; 

    /**
     * свойство хранит ошибки
     */
    public $errors = []; 

    /**
     * свойство для правил валидации данных
     */
    public $rules = []; 

    /**
     * организовываем подключение к БД
     */
    public function __construct() {
        Db::instance();
    }

    /**
     * метод загружает данные из формы в модель(например при регистрации или авторизации)
     */
    public function load($data){
        foreach($this->attributes as $name => $value){
            if(isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }

}