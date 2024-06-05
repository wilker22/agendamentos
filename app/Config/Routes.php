<?php

use App\Controllers\Super\HomeController;
use App\Controllers\Super\ServicesController;
use App\Controllers\Super\UnitsController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['as' => 'home']);

$routes->group('super', static function ($routes) {
    //home
    $routes->get('/', [HomeController::class, 'index'], ['as' => 'super.home']);

    $routes->group('units', static function ($routes) {
        $routes->get('/', [UnitsController::class, 'index'], ['as' => 'units']);
        $routes->get('new', [UnitsController::class, 'new'], ['as' => 'units.new']);
        $routes->post('create', [UnitsController::class, 'create'], ['as' => 'units.create']);
        $routes->get('edit/(:num)', [UnitsController::class, 'edit/$1'], ['as' => 'units.edit']);
        $routes->put('update/(:num)', [UnitsController::class, 'update/$1'], ['as' => 'units.update']);

        $routes->put('action/(:num)', [UnitsController::class, 'action/$1'], ['as' => 'units.action']);

        $routes->delete('destroy/(:num)', [UnitsController::class, 'destroy/$1'], ['as' => 'units.destroy']);
    });

    $routes->group('services', static function ($routes) {
        $routes->get('/', [ServicesController::class, 'index'], ['as' => 'services']);
        $routes->get('new', [ServicesController::class, 'new'], ['as' => 'services.new']);
        $routes->post('create', [ServicesController::class, 'create'], ['as' => 'services.create']);
        $routes->get('edit/(:num)', [ServicesController::class, 'edit/$1'], ['as' => 'services.edit']);
        $routes->put('update/(:num)', [ServicesController::class, 'update/$1'], ['as' => 'services.update']);

        $routes->put('action/(:num)', [ServicesController::class, 'action/$1'], ['as' => 'services.action']);

        $routes->delete('destroy/(:num)', [ServicesController::class, 'destroy/$1'], ['as' => 'services.destroy']);
    });
});
