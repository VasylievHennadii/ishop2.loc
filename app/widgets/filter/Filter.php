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

    /**
     * массив опций конкретного товара для редактирования, который достаем из БД 
     */
    public $filter;

    public function __construct($filter = null, $tpl = '') {
        $this->filter = $filter;
        $this->tpl = $tpl ? $tpl : __DIR__ . '/filter_tpl.php';
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
            $this->attrs = self::getAttrs();
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
        $filter = self::getFilter();//получаем строку фильтров через запятую
        if(!empty($filter)){
            $filter = explode(',', $filter);//в $filter получаем массив фильтров, разбитых по запятой
        }
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
    protected static function getAttrs(){
        $data = \R::getAssoc('SELECT * FROM attribute_value');
        $attrs = [];
        foreach($data as $k => $v){
            $attrs[$v['attr_group_id']][$k] = $v['value'];
        }
        return $attrs;
    }

    /**
     * метод возвращает строку с фильтрами
     */
    public static function getFilter(){
        $filter = null;
        if(!empty($_GET['filter'])){
            $filter = preg_replace("#[^\d,]+#", '', $_GET['filter']);
            $filter = trim($filter, ',');
        }
        return $filter;
    }

    /**
     * метод для фильтрации по группам
     */
    public static function getCountGroups($filter){
        $filters = explode(',', $filter);
        $cache = Cache::instance();
        $attrs = $cache->get('filter_attrs');
        if(!$attrs){
            $attrs = self::getAttrs();
        }
        $data = [];
        foreach($attrs as $key => $item){
            foreach($item as $k => $v){
                if(in_array($k, $filters)){
                    $data[] = $key;
                break;
                }
            }
        }
        return count($data);               
    }



}



?>