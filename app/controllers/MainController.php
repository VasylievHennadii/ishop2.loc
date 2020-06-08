<?php

namespace app\controllers;

use ishop\Cache;

// use R;

/**
 * контроллер главной страницы
 * 
 * @author user
 */
class MainController extends AppController {   

    public function indexAction(){  
        //$brands = \R::findAll('brand'); //получаем все бренды из БД
        $brands = \R::find('brand', 'LIMIT 3');//получаем 3 бренда из БД   
        $hits = \R::find('product', "hit = '1' AND status = '1' LIMIT 8");//получаем из таблицы product хиты со статусом 1 в кол-ве 8 шт     
        $this->setMeta('Главная страница', 'Описание...', 'Ключевики...');  
        $this->set(compact('brands', 'hits'));//передаем бренды и хиты в вид   
    }

}