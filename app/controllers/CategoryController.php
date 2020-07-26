<?php

namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Category;
use ishop\App;
use ishop\libs\Pagination;

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
        $breadcrumbs = Breadcrumbs::getBreadcrumbs($category->id);

        $cat_model = new Category();
        $ids = $cat_model->getIds($category->id);
        $ids = !$ids ? $category->id : $ids . $category->id;

        //пагинация
        //номер текущей страницы либо 1, либо берем из $_GET['page']
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = App::$app->getProperty('pagination');//кол-во товаров на страницу

        if($this->isAjax()){
            debug($_GET);
            die;
        }

        $total = \R::count('product', "category_id IN ($ids)");//получаем из БД общее кол-во товаров
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();// с какой записи нужно начинать выбирать
        
        $products = \R::find('product', "category_id IN ($ids) LIMIT $start, $perpage");
        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->set(compact('products', 'breadcrumbs', 'pagination', 'total'));
    }

}