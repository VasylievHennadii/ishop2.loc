<?php

namespace ishop;

/**
 * трейт заполняет объектом свойство $instance, если его там нет.
 * трейт-это значит, что данный код мы можем использовать в любом классе
 * (фактически копируем и вставляем в нужном нам классе)
 *
 * @author user
 */

trait TSingletone{

    private static $instance;

    /**
     * метод реализует правило:
     * если свойство текущего класса не инициализировано, 
     * тогда в него кладется объект данного класса
     * и возвращает этот объект
     */
    public static function instance(){
        if(self::$instance === null){
            self::$instance = new self;
        }
        return self::$instance;
    }

}