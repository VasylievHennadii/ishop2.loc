<?php

use ishop\App;

require_once dirname(__DIR__) . '/config/init.php';
require_once LIBS . '/functions.php'; //подключение файла со служебными функциями 

new \ishop\App();

debug(App::$app->getProperties());