<?php

namespace Config;

use App\Controllers\HomeController as WebController;
use App\Controllers\SchedulesController;
use App\Controllers\Super\HomeController;
use App\Controllers\Super\ServicesController;
use App\Controllers\Super\UnitsController;
use App\Controllers\Super\UnitsServicesController;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', [WebController::class, 'index'], ['as' => 'home']);


/**
 * @todo colocar filtros de permissão / autenticação
 */
$routes->group('super', static function ($routes) {

    // home
    $routes->get('/', [HomeController::class, 'index'], ['as' => 'super.home']);


    // rotas de unidades
    $routes->group('units', static function ($routes) {

        $routes->get('/', [UnitsController::class, 'index'], ['as' => 'units']);
        $routes->get('new', [UnitsController::class, 'new'], ['as' => 'units.new']);
        $routes->get('edit/(:num)', [UnitsController::class, 'edit/$1'], ['as' => 'units.edit']);
        $routes->post('create', [UnitsController::class, 'create'], ['as' => 'units.create']);
        $routes->put('update/(:num)', [UnitsController::class, 'update/$1'], ['as' => 'units.update']);
        $routes->put('action/(:num)', [UnitsController::class, 'action/$1'], ['as' => 'units.action']); // ativa / desativa um registro
        $routes->delete('destroy/(:num)', [UnitsController::class, 'destroy/$1'], ['as' => 'units.destroy']);


        // rotas dos serviços da unidade
        $routes->get('services/(:num)', [UnitsServicesController::class, 'services/$1'], ['as' => 'units.services']);
        $routes->put('services/store/(:num)', [UnitsServicesController::class, 'store/$1'], ['as' => 'units.services.store']);
    });


    // rotas de serviços
    $routes->group('services', static function ($routes) {

        $routes->get('/', [ServicesController::class, 'index'], ['as' => 'services']);
        $routes->get('new', [ServicesController::class, 'new'], ['as' => 'services.new']);
        $routes->get('edit/(:num)', [ServicesController::class, 'edit/$1'], ['as' => 'services.edit']);
        $routes->post('create', [ServicesController::class, 'create'], ['as' => 'services.create']);
        $routes->put('update/(:num)', [ServicesController::class, 'update/$1'], ['as' => 'services.update']);
        $routes->put('action/(:num)', [ServicesController::class, 'action/$1'], ['as' => 'services.action']); // ativa / desativa um registro
        $routes->delete('destroy/(:num)', [ServicesController::class, 'destroy/$1'], ['as' => 'services.destroy']);
    });
});



// rotas de agendamentos do user logado
$routes->group('schedules', static function ($routes) {

    $routes->get('/', [SchedulesController::class, 'index'], ['as' => 'schedules.new']);
    $routes->get('services', [SchedulesController::class, 'unitServices'], ['as' => 'get.unit.services']); // recuperamos via fetch API os serviços da unidade
    $routes->get('calendar', [SchedulesController::class, 'getCalendar'], ['as' => 'get.calendar']); // recuperamos via fetch API o calendário para o mês desejado
    $routes->get('hours', [SchedulesController::class, 'getHours'], ['as' => 'get.hours']); // recuperamos via fetch API os horários disponíveis
});





/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
