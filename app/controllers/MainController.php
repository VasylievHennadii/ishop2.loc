<?php

namespace app\controllers;

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
        $names = ['Andrey', 'Jane'];
        $this->set(compact('name', 'age', 'names', 'posts'));
        
    }

}