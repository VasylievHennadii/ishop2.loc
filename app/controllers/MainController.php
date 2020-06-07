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
        $this->setMeta('Главная страница', 'Описание...', 'Ключевики...');     
    }

}