<?php

namespace ishop\base;

use ishop\Db;
use Valitron\Validator;

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

    /**
     * метод сохранения данных от users в БД
     */
    public function save($table){
        $tbl = \R::dispense($table);
        foreach($this->attributes as $name => $value){
            $tbl->$name = $value;
        }
        return \R::store($tbl);
    }

    /**
     * метод обновления данных в таблице
     */
    public function update($table, $id){
        $bean = \R::load($table, $id);
        foreach($this->attributes as $name => $value){
            $bean->$name = $value;
        }
        return \R::store($bean);
    }


    /**
     * метод валидации с помощью плагина валидации vlucas\valitron
     */
    public function validate($data){  
        Validator::langDir(WWW . '/myValidator/lang');
        Validator::lang('ru');      
        $v = new Validator($data);
        $v->rules($this->rules);
        if($v->validate()){
            return true;
        }
        $this->errors = $v->errors();
        return false;
    }

    /**
     * метод вывода ошибок
     */
    public function getErrors(){
        $errors = '<ul>';
        foreach($this->errors as $error){
            foreach($error as $item){
                $errors .= "<li>$item</li>";
            }
        }
        $errors .= '</ul>';
        $_SESSION['error'] = $errors;
    }

}