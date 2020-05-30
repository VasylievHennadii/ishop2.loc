<?php

namespace ishop;

/**
 * Description of App
 *
 * @author user
 */
class App {

    /**
     * контейнер для нашего приложения
     */
    public static $app; 

    public function __construct() {
        $query = trim($_SERVER['QUERY_STRING'], '/'); //записываем строку запроса в $query и обрезаем концевой слэш
        session_start();
        self::$app = Registry::instance();
        $this->getParams();
        new ErrorHandler();
        Router::dispatch($url);
    }

    /**
     * метод получает все настройки приложения из params.php и кладет в контейнер $app
     */
    protected function getParams(){
        $params = require_once CONF . '/params.php';
        if(!empty($params)){
            foreach($params as $k => $v){
                self::$app->setProperty($k, $v);
            }
        }
    }

}
