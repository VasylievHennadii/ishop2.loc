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
    public $layout;
    public $prefix;
    /**
     * данные, которые передаем из контроллера в вид
     */
    public $data = [];
    /**
     * хранятся метаданные
     */
    public $meta = ['title' => '', 'desc' => '', 'keywords' => ''];

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
     * метод создает объект вида и вызывает метод render()
     */
    public function getView(){
        $viewObject = new View($this->route, $this->layout, $this->view, $this->meta);
        $viewObject->render($this->data);
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

    /**
     * eсли запрос от Ajax пришел асинхронный, то метод возвращает true
     */
    public function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * метод возвращает html ответ на Ajax запрос
     */
    public function loadView($view, $vars = []){
        extract($vars);
        require APP . "/views/{$this->prefix}{$this->controller}/{$view}.php";
        die;
    }



}