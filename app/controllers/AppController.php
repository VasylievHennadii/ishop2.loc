<?php

namespace app\controllers;

use app\models\AppModel;
use app\widgets\currency\Currency;
use ishop\App;
use ishop\base\Controller;

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

        //debug(App::$app->getProperties());//смотрим все свойства нашего контейнера(реестра)       
    }

}