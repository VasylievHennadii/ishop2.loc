<?php 

namespace app\widgets\filter;

use ishop\Cache;

/**
 * класс фильтра товаров
 */
class Filter{

    /**
     * свойство содержит группы
     */
    public $groups;

    /**
     * свойство содержит атрибуты
     */
    public $attrs;

    /**
     * свойство содержит путь к шаблону
     */
    public $tpl;

    public function __construct() {
        $this->tpl = __DIR__ . '/filter_tpl.php';
        $this->run();
    }

    
    protected function run(){
        $cache = Cache::instance();//создаем объект Cache, в котором будут храниться отдельно группы и атрибуты

        $this->groups = $cache->get('filter_group');//получаем группы из кеша, если они там есть

        //если групп нет в кеше, то получаем из БД и кешируем
        if(!$this->groups){
            $this->groups = $this->getGroups();
            $cache->set('filter_group', $this->groups, 30);
        }

        $this->attrs = $cache->get('filter_attrs');//получаем атрибуты из кеша, если они там есть

        //если атрибутов нет в кеше, то получаем из БД и кешируем
        if(!$this->attrs){
            $this->attrs = $this->getAttrs();
            $cache->set('filter_attrs', $this->attrs, 30);
        }
        $filters = $this->getHtml();
        echo $filters;
    }


    /**
     * метод получает html код
     */
    protected function getHtml(){
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }


    /**
     * метод получает группы из БД(таблица attribute_group) 
     */
    protected function getGroups(){
        return \R::getAssoc('SELECT id, title FROM attribute_group');
    }


    /**
     * метод получает атрибуты из БД
     */
    protected function getAttrs(){
        $data = \R::getAssoc('SELECT * FROM attribute_value');
        $attrs = [];
        foreach($data as $k => $v){
            $attrs[$v['attr_group_id']][$k] = $v['value'];
        }
        return $attrs;
    }

    public static function getFilter(){
        $filter = null;
        if(!empty($_GET['filter'])){
            $filter = preg_replace("#[^\d,]+#", '', $_GET['filter']);
            $filter = trim($filter, ',');
        }
        return $filter;
    }



}



?>