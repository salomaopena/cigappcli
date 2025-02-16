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
