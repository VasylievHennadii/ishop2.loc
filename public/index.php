<?php

use ishop\App;
use ishop\Router;

require_once dirname(__DIR__) . '/config/init.php';
require_once LIBS . '/functions.php'; //подключение файла со служебными функциями 
require_once CONF . '/routes.php';

new \ishop\App();

