<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Main::index');
$routes->get('/init','Main::init');
$routes->get('/init/error','Main::init_error');
$routes->get('/init/error/(:alphanum)','Main::init_error/$1');
$routes->get('/stop','Main::stop');


//orders routs
$routes->get('/order','Order::index');
$routes->get('/order/set_filter/(:alphanum)','Order::setFilter/$1');
$routes->get('/order/add','Order::add');
$routes->get('/order/(:num)','Order::view/$1');
$routes->get('/order/edit/(:num)','Order::edit/$1');
$routes->get('/order/delete/(:num)','Order::delete/$1');
$routes->post('/order/save','Order::save');
