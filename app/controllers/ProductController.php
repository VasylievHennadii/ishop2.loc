<?php

namespace app\controllers;

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

        //связанные товары
        $related = \R::getAll("SELECT * FROM related_product JOIN product ON product.id = related_product.related_id WHERE related_product.product_id = ?", [$product->id]);
        

        //запись в куки полученнго товара

        //просмотренные товары

        //галерея
        $gallery = \R::findAll('gallery', 'product_id = ?', [$product->id]);
        

        //модификации товара

        $this->setMeta($product->title, $product->description, $product->keywords);//установка метаданных
        $this->set(compact('product', 'related','gallery'));
    }

}