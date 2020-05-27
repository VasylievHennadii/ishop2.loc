<?php

use ishop\App;

require_once dirname(__DIR__) . '/config/init.php';

new \ishop\App();

var_dump(App::$app->getProperties());