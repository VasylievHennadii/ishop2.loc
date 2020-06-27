<?php

namespace app\controllers;

use app\models\Category;

/**
 * контроллер для просмотра выбранной категории товара
 */
class CategoryController extends AppController {

    public function viewAction(){
        //debug($this->route);
        $alias = $this->route['alias'];
        $category = \R::findOne('category', 'alias = ?', [$alias]);//в массиве категорий есть только id текущей
        if(!$category){
            throw new \Exception('Страница не найдена', 404);
        } 

        //хлебные крошки
        $breadcrumbs = '';

        $cat_model = new Category();
        $ids = $cat_model->getIds($category->id);
        $ids = !$ids ? $category->id : $ids . $category->id;
        
        $products = \R::find('product', "category_id IN ($ids)");
        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->set(compact('products', 'breadcrumbs'));
    }

}