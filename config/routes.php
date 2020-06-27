<?php

/**
 * файл содержит правила маршрутизации
 */

use ishop\Router;

//пользовательские маршруты
//для продукта
Router::add('^product/(?P<alias>[a-z0-9-]+)/?$', ['controller' => 'Product', 'action' => 'view']);

//для категорий
Router::add('^category/(?P<alias>[a-z0-9-]+)/?$', ['controller' => 'Category', 'action' => 'view']);

//default routes -admin- дефолтный маршрут для админской части
Router::add('^admin$', ['controller' => 'Main', 'action' => 'index', 'prefix' => 'admin']);
Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'admin']);

//default routes дефолтный маршрут для пользовательской части
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');