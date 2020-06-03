<?php

namespace ishop\base;

/**
 * Базовый общий контроллер, в котором будет выполняться любой общий код,
 * который мы хотим видеть в других контроллерах,
 * все методы и свойства будут доступны в других контроллерах
 * 
 * @author user
 */
abstract class Controller {

    /**
     * свойство содержит массив с текущим маршрутом
     */
    public $route;
    public $controller;
    public $model;
    public $view;
    public $prefix;
    /**
     * данные, которые передаем из контроллера в вид
     */
    public $data = [];
    /**
     * хранятся метаданные
     */
    public $meta = [];

    /**
     * конструктор, который заполняем всеми необходимыми данными
     */
    public function __construct($route){
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->model = $route['controller'];
        $this->view = $route['action'];
        $this->prefix = $route['prefix'];
    }

    /**
     * метод в $data помещает некие переданные данные
     */
    public function set($data){
        $this->data = $data;
    }

    /**
     * метод для передачи метаданных
     */
    public function setMeta($title = '', $desc = '', $keywords = ''){
        $this->meta['title'] = $title; 
        $this->meta['desc'] = $desc;
        $this->meta['keywords'] = $keywords;
    }

}