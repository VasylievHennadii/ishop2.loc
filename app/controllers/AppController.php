<?php

namespace app\controllers;

use app\models\AppModel;
use app\widgets\currency\Currency;
use ishop\App;
use ishop\base\Controller;
use ishop\Cache;

/**
 * общий контроллер для нашего приложения,
 * наследует базовый класс контроллера Controller
 * 
 * @author user
 */
class AppController extends Controller {

    public function __construct($route) {
        parent::__construct($route);
        new AppModel();
        //setcookie('currency', 'EUR', time() + 3600*24*7, '/');//пример изменения активной валюты в Cookies
        // $curr = Currency::getCurrencies();
        
        App::$app->setProperty('currencies', Currency::getCurrencies());//записываем в реестр данные о валютах
        App::$app->setProperty('currency', Currency::getCurrency(App::$app->getProperty('currencies')));//записываем в реестр(контейнер) данные об активной валюте
        App::$app->setProperty('cats', self::cacheCategory());//записываем массив категорий в контейнер

        //debug(App::$app->getProperties());//смотрим все свойства нашего контейнера(реестра)       
    }

    /**
     * кладет в кеш массив категорий, который используется для формирования меню.
     * если данные есть в кеше - мы их возвращаем, иначе - получаем из БД и возвращаем
     */
    public static function cacheCategory(){
        $cache = Cache::instance();
        $cats = $cache->get('cats');
        if(!$cats){
            $cats = \R::getAssoc("SELECT * FROM category");
            $cache->set('cats', $cats);
        }
        return $cats;
    }

}