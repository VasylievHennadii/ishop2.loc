<?php

/**
 * режим разработки(1) или продакшена(0)
 */
define("DEBUG", 1); 
/**
 * константа указывает на корень нашего сайта ishop2.loc
 */
define("ROOT", dirname(__DIR__)); 
/**
 * константа указывает на папку '/public'
 */
define("WWW", ROOT . '/public');
/**
 * константа указывает на папку '/app'
 */
define("APP", ROOT . '/app');
/**
 * константа указывает на папку '/vendor/ishop/core'
 */
define("CORE", ROOT . '/vendor/ishop/core');
/**
 * константа указывает на папку '/vendor/ishop/core/libs'
 */
define("LIBS", ROOT . '/vendor/ishop/core/libs');
/**
 * константа указывает на папку '/tmp/cache'
 */
define("CACHE", ROOT . '/tmp/cache');
/**
 * константа указывает на папку '/config'
 */
define("CONF", ROOT . '/config');
/**
 * в константе хранится шаблон нашего сайта по умолчанию
 */
define("LAYOUT", 'default');

$app_path = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}"; //получаем строку вида http://ishop2.loc/public/index.php
$app_path = preg_replace("#[^/]+$#", '', $app_path); //получаем строку вида http://ishop2.loc/public/
$app_path = str_replace('/public/', '', $app_path); //строку вида http://ishop2.loc

/**
 * URL главной страницы, строкa вида http://ishop2.loc
 */
define("PATH", $app_path);

/**
 * константа ведет на админку сайта '/admin'
 */
define("ADMIN", PATH . '/admin');

require_once ROOT . '/vendor/autoload.php'; //подключаем автозагрузчик композера - autoload.php