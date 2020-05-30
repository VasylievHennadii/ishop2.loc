<?php

namespace ishop;

/**
 * Класс маршрутизатор
 *
 * @author user
 */

class Router {

    /**
     * свойство содержит таблицу маршрутов
     */
    protected static $routes = [];

    /**
     * свойство содержит текущий маршрут
     */
    protected static $route = [];

    /**
     * метод записывает правила в таблицу маршрутов $routes.
     * записываем в таблицу маршрутов данный маршрут $route
     */
    public static function add($regexp, $route = []) {
        self::$routes[$regexp] = $route; 
    }

    /**
     * тестовый метод.
     * метод возвращает таблицу маршрутов $routes
     */
    public static function getRoutes(){
        return self::$routes;
    }

    /**
     * тестовый метод.
     * метод возвращает текущий маршрут $route
     */
    public static function getRoute(){
        return self::$route;
    }

    /**
     * данный метод вызывает метод matchRoute() и проверяет $url адрес на соответствие в таблице маршрутов: 
     * true -> вызывает соответствующий контроллер, 
     * false-> вовращает ошибку 404
     */
    public static function dispatch($url){
        if(self::matchRoute($url)){
            echo 'OK';
        }else{
            echo 'NO';
        }
    }

    /**
     * метод принимает $url адрес и ищет соответствие в таблице маршрутов
     */
    public static function matchRoute($url){
        return true;
    }


}