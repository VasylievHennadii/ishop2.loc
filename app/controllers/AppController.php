<?php

namespace app\controllers;

use app\models\AppModel;
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
    }

}