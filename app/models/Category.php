<?php

namespace app\models;

use ishop\App;

/**
 * модель для просмотра выбранной категории товара
 */
class Category extends AppModel {

    public $attributes = [
        'title' => '',
        'parent_id' => '',
        'keywords' => '',
        'description' => '',
        'alias' => '',
    ];

    /**
     * правило для вaлидации
     */
    public $rules = [
        'required' => [
            ['title'],
        ]
    ];

    /**
     * метод для получения id всех вложенных категорий
     */
    public function getIds($id){
        $cats = App::$app->getProperty('cats');//весь массив категорий
        //debug($cats);
        $ids = null;
        foreach($cats as $k => $v){
            if($v['parent_id'] == $id){
                $ids .= $k . ',';
                $ids .= $this->getIds($k);
            }
        }
        return $ids;
    }

}