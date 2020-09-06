<?php

namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Category;
use app\widgets\filter\Filter;
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

        /*пагинация*/
        //номер текущей страницы либо 1, либо берем из $_GET['page']
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = App::$app->getProperty('pagination');//кол-во товаров на страницу

        /*пагинация*/


        /*filters*/
        $sql_part = '';
        if(!empty($_GET['filter'])){
             /*
            SELECT `product`.*  FROM `product`  WHERE category_id IN (6) AND id IN
            (
            SELECT product_id FROM attribute_product WHERE attr_id IN (1,5) GROUP BY product_id HAVING COUNT(product_id) = 2
            )
            */
            $filter = Filter::getFilter();
            if($filter){
                $cnt = Filter::getCountGroups($filter);
                $sql_part = "AND id IN (SELECT product_id FROM attribute_product WHERE attr_id IN ($filter) GROUP BY product_id HAVING COUNT(product_id) = $cnt)";
            }            
        }        

        /*filters*/
        

        $total = \R::count('product', "category_id IN ($ids) $sql_part");//получаем из БД общее кол-во товаров
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();// с какой записи нужно начинать выбирать
        
        $products = \R::find('product', "status = '1' AND category_id IN ($ids) $sql_part LIMIT $start, $perpage");

        if($this->isAjax()){
            $this->loadView('filter', compact('products', 'total', 'pagination'));
        }

        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->set(compact('products', 'breadcrumbs', 'pagination', 'total'));
    }

}