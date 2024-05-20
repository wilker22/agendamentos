<?php

use App\Controllers\Super\HomeController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('super', [HomeController::class, 'index'], ['as' => 'super.home']);
