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
$routes->get('/', static function () {
    return redirect()->to(base_url('/login'));
});

// Login dan Register
$routes->get('/login', 'UserController::login', ['filter' => 'guest']);
$routes->post('/login', 'UserController::authenticate', ['filter' => 'guest']);
// $routes->get('/register', 'UserController::register', ['filter' => 'guest']);
// $routes->post('/register/store', 'UserController::store', ['filter' => 'guest']);
$routes->post('/logout', 'UserController::logout', ['filter' => 'auth']);


// Dashboard
$routes->get('/dashboard', 'UserController::index', ['filter' => 'auth']);

// Manajemen Barang
$routes->group('products', ['filter' => 'admin'], static function ($routes) {
    $routes->get('/', 'ProductController::index');
    $routes->get('add', 'ProductController::add');
    $routes->get('edit/(:num)', 'ProductController::edit/$1');
    $routes->post('store', 'ProductController::store');
    $routes->post('update', 'ProductController::update');
    $routes->get('delete/(:num)', 'ProductController::destroy/$1');
});

// Manajemen Karyawan
$routes->group('employees', ['filter' => 'admin'], static function ($routes) {
    $routes->get('/', 'EmployeeController::index');
    $routes->get('add', 'EmployeeController::add');
    $routes->get('edit/(:num)', 'EmployeeController::edit/$1');
    $routes->post('store', 'EmployeeController::store');
    $routes->post('update', 'EmployeeController::update');
    $routes->get('delete/(:num)', 'EmployeeController::destroy/$1');
});


// Manajemen Pemesanan
$routes->group('orders', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'OrderController::index');
    $routes->get('add', 'OrderController::add');
    $routes->post('store', 'OrderController::store');
    $routes->get('delete/(:segment)', 'OrderController::destroy/$1');
    $routes->get('show', 'OrderController::show');
    $routes->get('detail-product', 'OrderController::detailProduct');
    $routes->get('print', 'OrderController::print');
});


// Manajemen Transaksi
$routes->group('transactions', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'TransactionController::index');
    $routes->get('update/(:segment)', 'TransactionController::update/$1');
    $routes->get('print/(:segment)', 'TransactionController::print/$1');
});


// Manajemen Akun
$routes->group('users', ['filter' => 'auth'], static function ($routes) {
    $routes->get('(:segment)', 'UserController::edit/$1');
    $routes->post('update', 'UserController::update');
    $routes->post('show', 'UserController::show');
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
