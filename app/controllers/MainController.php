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
        $this->setMeta('Главная страница', 'Описание...', 'Ключевики...');  
        $this->set(compact('brands'));//передаем бренды в вид   
    }

}