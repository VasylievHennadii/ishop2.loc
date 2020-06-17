<?php

namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Product;

/**
 * контроллер для карточки товара
 */
class ProductController extends AppController {

    /**
     * метод(action) для просмотра конкретного товара, который мы получаем по 'alias' из 'route'
     */
    public function viewAction(){
        //debug($this->route); //Array ([controller] => Product, [action] => view, [alias] => casio-mq-24-7bul, prefix] => )
        $alias = $this->route['alias'];//получаем alias
        $product = \R::findOne('product', "alias = ? AND status = '1'", [$alias]); //получаем данные по товару из БД (в записи 'alias = ?' знак ? нужен для защиты от sql-инъекций)
        //debug($product);
        if(!$product){
            throw new \Exception("Страница '{$alias}' не найдена", 404);
        }

        //хлебные крошки
        $breadcrumbs = Breadcrumbs::getBreadcrumbs($product->category_id, $product->title);

        //связанные товары
        $related = \R::getAll("SELECT * FROM related_product JOIN product ON product.id = related_product.related_id WHERE related_product.product_id = ?", [$product->id]);
        

        //запись в куки полученнго товара
        $p_model = new Product();
        $p_model->setRecentlyViewed($product->id);

        //просмотренные товары
        $r_viewed = $p_model->getRecentlyViewed();        
        $recentlyViewed = null;
        if($r_viewed){
            //формируем запрос вида: SELECT `product`.*  FROM `product`  WHERE id IN (?,?,?) LIMIT 3
            $recentlyViewed = \R::find('product', 'id IN (' . \R::genSlots($r_viewed) . ') LIMIT 3', $r_viewed);
        }

        //галерея
        $gallery = \R::findAll('gallery', 'product_id = ?', [$product->id]);
        

        //модификации товара

        $this->setMeta($product->title, $product->description, $product->keywords);//установка метаданных
        $this->set(compact('product', 'related', 'gallery', 'recentlyViewed', 'breadcrumbs'));
    }

}