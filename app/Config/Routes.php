<?php

namespace Config;

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
$routes->get('/', 'Home::index');

// Login dan Register
$routes->get('/login', 'UserController::login', ['filter' => 'guest']);
$routes->post('/login', 'UserController::authenticate', ['filter' => 'guest']);
$routes->get('/register', 'UserController::register', ['filter' => 'guest']);
$routes->post('/register/store', 'UserController::store', ['filter' => 'guest']);
$routes->post('/logout', 'UserController::logout', ['filter' => 'auth']);


// Dashboard
$routes->get('/dashboard', 'UserController::index', ['filter' => 'auth']);

// Manajemen Barang
$routes->get('/products', 'ProductController::index', ['filter' => 'auth']);
$routes->get('/products/add', 'ProductController::add', ['filter' => 'auth']);
$routes->get('/products/edit/(:num)', 'ProductController::edit/$1', ['filter' => 'auth']);
$routes->post('/products/store', 'ProductController::store', ['filter' => 'auth']);
$routes->post('/products/update', 'ProductController::update', ['filter' => 'auth']);
$routes->post('/products/delete/(:num)', 'ProductController::destroy/$1', ['filter' => 'auth']);

// Manajemen Karyawan
$routes->get('/employees', 'EmployeeController::index', ['filter' => 'auth']);
$routes->get('/employees/add', 'EmployeeController::add', ['filter' => 'auth']);
$routes->get('/employees/edit/(:num)', 'EmployeeController::edit/$1', ['filter' => 'auth']);
$routes->post('/employees/store', 'EmployeeController::store', ['filter' => 'auth']);
$routes->post('/employees/update', 'EmployeeController::update', ['filter' => 'auth']);
$routes->post('/employees/delete/(:num)', 'EmployeeController::destroy/$1', ['filter' => 'auth']);



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
