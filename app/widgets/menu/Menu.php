<?php

namespace app\widgets\menu;

use ishop\App;
use ishop\Cache;

/**
 * класс меню
 */
class Menu {

    /**
     * свойство для данных
     */
    protected $data;
    /**
     * массив дерево, которое строим из $data
     */
    protected $tree;

    /**
     * готовый html код нашего меню
     */
    protected $menuHtml;

    /**
     * свойство, в котором хранится шаблон для меню
     */
    protected $tpl;

    /**
     * контейнер для нашeго меню(= 'ul')
     */
    protected $container = 'ul';

    /**
     * таблица в БД, из которых необходимо выбирать эти самые данные(= 'category')
     */
    protected $table = 'category';

    /**
     * на какое время кешируются данные(= 3600)
     */
    protected $cache = 3600;

    /**
     * ключ, под которым сохраняются данные кеша
     */
    protected $cacheKey = 'ishop_menu';

    /**
     * массив дополнительных атрибутов для меню
     */
    protected $attrs = [];

    /**
     * свойство для админки
     */
    protected $prepend = '';


    /**
     * заполняет недостающие свойства и получает опции
     */
    public function __construct($options = []) {
        $this->tpl = __DIR__ . '/menu_tpl/menu.php';
        $this->getOptions($options);
        // debug($this->table);
        $this->run();
    }

    /**
     * метод для получения опций. 
     * принимает настройки виджета и заполняет свойства, которые мы даем пользователю
     */
    protected function getOptions($options){
        foreach($options as $k => $v){
            if(property_exists($this, $k)){
                $this->$k = $v;
            }
        }
    }

    /**
     * метод формирует наше меню
     */
    protected function run(){
        $cache = Cache::instance();//кешируем данные для меню
        $this->menuHtml = $cache->get($this->cacheKey);
        if(!$this->menuHtml){
            $this->data = App::$app->getProperty('cats');
            if($this->data){
                $this->data = $cats = \R::getAssoc("SELECT * FROM {$this->table}");
            }
        }
        $this->output();
    }

    /**
     * метод для вывода меню
     */
    protected function output(){
        echo $this->menuHtml;
    }

    /**
     * метод получающий дерево
     */
    protected function getTree(){

    }

    /**
     * метод для формирования вложенных уровней меню
     */
    protected function getMenuHtml($tree, $tab = ''){

    }

    /**
     * метод из одной категории формирует кусок html кода
     */
    protected function catToTemplate($category, $tab, $id){

    }




}