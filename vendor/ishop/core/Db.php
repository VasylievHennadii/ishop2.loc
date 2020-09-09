<?php

namespace ishop;

// use Exception;

/**
 * в данном классе устанавливается подключение к серверу БД. 
 * релизуется паттерн Singletone с помощью трейта TSingletone
 */
class Db {

    use TSingletone;

    /**
     * в переменной $db мы получаем массив из config_db.php
     */
    protected function __construct() {
        $db = require_once CONF . '/config_db.php';
        class_alias('\RedBeanPHP\R', '\R');
        \R::setup($db['dsn'], $db['user'], $db['pass']);
        if( !\R::testConnection() ) {
            throw new \Exception("Нет соединения с БД", 500);
        }
        \R::freeze(true);//запрещаем изменение полей в таблице БД автоматически
        if(DEBUG){
            \R::debug(true, 1);//разрешаем дебаггинг, включаем режим отладки
        }

        //функция из ReadBeen для разрешения именования таблиц со знаком '_'. Пример 'attribute_value', 'attr_group_id'.
        \R::ext('xdispense', function($type){
            return \R::getRedBean()->dispense($type);
        });
    }

}