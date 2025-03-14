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
$routes->get('/order/cancel/','Order::cancel');
$routes->get('/order/checkout','Order::checkout');
$routes->get('/order/add/(:alphanum)','Order::add/$1');
$routes->get('/order/add/confirm/(:alphanum)/(:num)','Order::add_confirm/$1/$2');
$routes->get('/order/remove/(:alphanum)','Order::remove/$1');
$routes->get('/order/checkout/payment/','Order::order_checkout_payment');
$routes->get('/order/payment/process','Order::order_payment_process');
$routes->post('/order/checkout/payment/confirm','Order::checkout_payment_confirm');
