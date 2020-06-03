<?php

namespace ishop\base;

/**
 * базовый класс вида
 */
class View {

    /**
     * свойство содержит массив с текущим маршрутом
     */
    public $route;
    public $controller;
    public $model;
    public $view;
    public $prefix;
    public $layout;
    /**
     * данные, которые передаем из контроллера в вид
     */
    public $data = [];
    /**
     * хранятся метаданные
     */
    public $meta = [];

    /**
     * конструктор, который заполняем всеми необходимыми данными,
     * $layout - шаблон(хедер, футер, сайдбар и т.д. постоянная часть страницы),
     * $view - вид (динамическая часть страницы)
     */
    public function __construct($route, $layout = '', $view = '', $meta){
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->model = $route['controller'];
        $this->view = $view;
        $this->prefix = $route['prefix'];
        $this->meta = $meta;
        if($layout === false){
            $this->layout = false;
        }else{
            $this->layout = $layout ?: LAYOUT; //если что-то передано в $layout, то мы возьмем его. Иначе - берем дефолтный вид из LAYOUT
        }
    }

}