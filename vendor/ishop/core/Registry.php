<?php

namespace ishop;

/**
 * класс реализует паттерн Singleton
 * клас для свойств
 *
 * @author user
 */

class Registry {

    use TSingletone; //вставляем трейд

    /**
     * контейнер для всех свойств
     */
    protected static $properties = []; 

    /**
     * метод складывает свойства в контейнер в виде массива,
     *  ключ  $name, значение $value
     */
    public static function setProperty($name, $value){
        self::$properties[$name] = $value;
    }

     /**
      * метод получает свойство из контейнера.
      * если существует, то мы возвращаем. Иначе null
      */
    public function getProperty($name){
        if(isset(self::$properties[$name])){
            return self::$properties[$name];
        }
        return null;
    }

    /**
     * метод распечатывает все доступные свойства
     */
    public function getProperties(){
        return self::$properties;
    }

}