<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
// Auth Routes (staff login)
$routes->get('/login', 'AuthController::login'); // Halaman login
$routes->post('/loginPost', 'AuthController::loginPost'); // Proses login
$routes->get('/register', 'AuthController::register'); // Halaman register
$routes->post('/registerPost', 'AuthController::registerPost'); // Proses register
$routes->get('/logout', 'AuthController::logout'); // Logout

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/catalog', 'Home::katalog');
    $routes->post('/add-to-cart', 'TrolleyController::addToCart');
    $routes->get('/cart', 'TrolleyController::viewCart');
    $routes->post('/remove-from-cart', 'TrolleyController::removeFromCart');
    $routes->post('/checkout', 'TrolleyController::checkout');
    $routes->post('/update-quantity', 'TrolleyController::updateQuantity');
    $routes->get('/payments/detail/(:num)', 'PaymentController::detail/$1');
    $routes->get('/payments', 'PaymentController::index');
});
$routes->get('/payments/validation', 'PaymentController::validationPage', ['filter' => 'staffonly']);
$routes->get('/payments/validate/(:num)', 'PaymentController::validatePayment/$1', ['filter' => 'staffonly']);
$routes->get('/payments/cancel/(:num)', 'PaymentController::cancelPayment/$1', ['filter' => 'staffonly']);

// Staff-only Routes (perlu login)
$routes->group('dashboard', ['filter' => 'staffonly'], function($routes) {
    $routes->get('/', 'DashboardController::index'); // Dashboard summary
    $routes->get('product_details', 'DashboardController::productDetails'); // Monitoring produk
    $routes->get('item/create', 'ItemController::create');
    $routes->post('item/store', 'ItemController::store');
});

$routes->group('products', ['filter' => 'staffonly'], function($routes) {
    $routes->get('/', 'ProductController::index');
    $routes->get('create', 'ProductController::create');
    $routes->post('store', 'ProductController::store');
    $routes->get('edit/(:num)', 'ProductController::edit/$1');
    $routes->post('update/(:num)', 'ProductController::update/$1');
    $routes->post('delete/(:num)', 'ProductController::delete/$1');
});
$routes->get('/products/detail/(:segment)', 'ProductController::detail/$1');

$routes->post('/rfids/register', 'RfidsController::registerFromNodeMCU');
$routes->post('/rfids/scanning', 'RfidsController::addProduct');