<?php

namespace ishop\base;

use ishop\Db;

/**
 * класс отвечает за работу с данными,
 * в первую очередь с Базой Данных, 
 * но ещё и валидация и обработка данных для функций и т.д.
 */
abstract class Model {

    public $attributes = []; //хранит массив свойств модели, который идентичен полям в таблице БД
    public $errors = []; //складываем сюда ошибки
    public $rules = []; //свойство для правил валидации данных

    /**
     * организовываем подключение к БД
     */
    public function __construct() {
        Db::instance();
    }

}