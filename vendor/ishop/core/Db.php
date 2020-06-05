<?php

namespace ishop;

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
    }

}