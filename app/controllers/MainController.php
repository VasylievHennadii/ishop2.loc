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
        $posts = \R::findAll('test');
        $post = \R::findOne('test', 'id=?', [2]);                   
       
        // $this->setMeta(App::$app->getProperty('shop_name'), 'Описание...', 'Ключевики...');
        $this->setMeta('Главная страница', 'Описание...', 'Ключевики...');
        $name = 'John';
        $age = 30;
        $names = ['Andrey', 'Jane', 'Mike'];
        $cache = Cache::instance();
        // $cache->set('test', $names);//поучение данных в кеш(кеширование данных)
        // $cache->delete('test');
        $data = $cache->get('test');//получение данных из кеша
        if(!$data){
            $cache->set('test', $names);
        }
        debug($data);
        $this->set(compact('name', 'age', 'names', 'posts'));
        
    }

}