<?php

namespace ishop\base;

use Exception;

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

    /**
     * метод, который формирует страничку для пользователя,
     * формирует путь к layout и view
     */
    public function render($data){
        $viewFile = APP . "/views/{$this->prefix}{$this->controller}/{$this->view}.php";//путь к виду
        if(is_file($viewFile)){
            ob_start();//включаем буферизацию
            require_once $viewFile;//подключаем вид, если он есть
            $content = ob_get_clean();//вернем всё в $content, в которой хранится сам вид, и очищаем буфер
        }else{
            throw new Exception("Не найден вид {$viewFile}", 500);
        }
        
        //подключение шаблона
        if(false !== $this->layout){
            $layoutFile = APP . "/views/layouts/{$this->layout}.php";//путь к шаблону
            if(is_file($layoutFile)){                
                require_once $layoutFile;//подключаем вид, если он есть                
            }else{
                throw new Exception("Не найден вид {$this->layout}", 500);
            }
        }
    }

    /**
     * 
     */
    public function getMeta(){
        
    }

}