<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default routes
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('BarangController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true); // boleh true dulu untuk fase awal dev, nanti produksi bisa false

// Guest Routes (pengunjung)
$routes->get('/', 'BarangController::index'); // Home = list barang
$routes->get('/barang', 'BarangController::index');
$routes->get('/payment/create/(:num)', 'PaymentController::create/$1'); // Form pembayaran
$routes->post('/payment/store', 'PaymentController::store'); // Proses simpan pembayaran

// Auth Routes (staff login)
$routes->get('/login', 'AuthController::login'); // Halaman login
$routes->post('/loginPost', 'AuthController::loginPost'); // Proses login
$routes->get('/register', 'AuthController::register'); // Halaman register
$routes->post('/registerPost', 'AuthController::registerPost'); // Proses register
$routes->get('/logout', 'AuthController::logout'); // Logout

// Staff-only Routes (perlu login)
$routes->group('dashboard', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Home::index'); // Halaman utama dashboard staff
    
    // Manajemen Barang
    $routes->get('barang', 'BarangController::manage'); // Staff: manage barang
    $routes->get('barang/edit/(:num)', 'BarangController::edit/$1');
    $routes->post('barang/update/(:num)', 'BarangController::update/$1');
    
    // Manajemen Pembayaran
    $routes->get('payment', 'PaymentController::manage'); // Staff: lihat pembayaran
    $routes->get('payment/validate/(:num)', 'PaymentController::validatePayment/$1');
    $routes->get('payment/reject/(:num)', 'PaymentController::rejectPayment/$1');
});
