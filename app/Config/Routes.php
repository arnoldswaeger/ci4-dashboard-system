<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(true);

// Dashboard Routes
$routes->get('/', 'DashboardController::index');
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('dashboard/statistics', 'DashboardController::statistics', ['filter' => 'auth']);
$routes->get('dashboard/profile', 'DashboardController::profile', ['filter' => 'auth']);

// User Management Routes (Admin only)
$routes->group('user', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'UserController::index');
    $routes->get('create', 'UserController::create');
    $routes->post('store', 'UserController::store');
    $routes->get('edit/(:num)', 'UserController::edit/$1');
    $routes->post('update/(:num)', 'UserController::update/$1');
    $routes->delete('delete/(:num)', 'UserController::delete/$1');
    $routes->get('show/(:num)', 'UserController::show/$1');
});

// Auth Routes (handled by Shield)
if (config('Auth')->views['login'] !== false) {
    $routes->get('login', 'Auth\AuthController::login', ['filter' => 'noauth']);
    $routes->post('login', 'Auth\AuthController::loginAction', ['filter' => 'noauth']);
}

if (config('Auth')->views['register'] !== false) {
    $routes->get('register', 'Auth\AuthController::register', ['filter' => 'noauth']);
    $routes->post('register', 'Auth\AuthController::registerAction', ['filter' => 'noauth']);
}

$routes->post('logout', 'Auth\AuthController::logoutAction', ['filter' => 'auth']);

// Catch-all
$routes->match(['get', 'post'], '(:any)', '$1');
