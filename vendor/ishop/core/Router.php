<?php

namespace ishop;

use Exception;

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
     * получаем запрос из класса App.
     * данный метод вызывает метод matchRoute() и проверяет $url адрес на соответствие в таблице маршрутов: 
     * true -> вызывает соответствующий контроллер, 
     * false-> вовращает ошибку 404
     */
    public static function dispatch($url){
        $url = self::removeQueryString($url);     
        if(self::matchRoute($url)){
            $controller = 'app\controllers\\' . self::$route['prefix'] . self::$route['controller'] . 'Controller';//такой вид строки 'app\controllers\pageController'

           if(class_exists($controller)){
                $controllerObject = new $controller(self::$route); //создаем объект контроллера и передаем в конструктор объекта все параметры $route
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';
                if(method_exists($controllerObject, $action)){
                    $controllerObject->$action();//вызываем метод объекта контроллера
                    $controllerObject->getView();//вызываем метод базового контроллера Controller
                }else{
                    throw new \Exception("Метод $controller::$action не найден", 404);
                }
            }else{
                throw new \Exception("Контроллер $controller не найден", 404);
            }
        }else{
           throw new \Exception("Страница не найдена", 404);
        }
    }

    /**
     * метод принимает $url адрес и ищет соответствие в таблице маршрутов.
     * возвращает true/false
     * $pattern - шаблон регулярного выражения
     */
    public static function matchRoute($url){
        foreach(self::$routes as $pattern => $route){
            //сравниваем шаблон $pattern с $url и помещаем в $matches
            if(preg_match("#{$pattern}#", $url, $matches)){
                foreach($matches as $k => $v){
                    if(is_string($k)){
                        $route[$k] = $v;
                    }
                }
                if(empty($route['action'])){
                    $route['action'] = 'index';
                }
                if(!isset($route['prefix'])){
                    $route['prefix'] = '';
                }else{
                    $route['prefix'] .= '\\';
                }
                $route['controller'] = self::upperCamelCase($route['controller']); // получаем вид app\controllers\PageNewController из вида page-new
                self::$route = $route;
                // debug($matches);
                // debug(self::$route);
                return true;
            }
        }
        return false;
    }

    /**
     * метод приводит наименование к такому формату - CamelCase.
     * пример строки page-new -> PageNew
     */
    protected static function upperCamelCase($name){        
        //$name = str_replace('-', ' ', $name); // заменяем '-' на ' '; получаем page new
        //$name = ucwords($name); // получаем Page New
        //$name = str_replace(' ', '', $name); // получаем PageNew        
        // debug($name);
        return $name = str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    /**
     * метод приводит наименование к такому формату - camelCase
     */
    protected static function lowerCamelCase($name){
        return lcfirst(self::upperCamelCase($name));
    }

    /**
     * метод для работы с GET параметрами
     */
    protected static function removeQueryString($url){
        //из строки $url "page/view/&id=1&page=2" получаем:
        if($url){
            $params = explode('&', $url, 2);//получаем: Array ([0] => page/view/ , [1] => id=1&page=2)
            if(false === strpos($params[0], '=')){
                return rtrim($params[0], '/');//если в [0] нет '=', то мы его вовращаем обрезая '/'
            }else{
                return '';
            }
        }
    }


}