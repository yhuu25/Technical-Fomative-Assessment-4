<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Pages::home');
$routes->get('/about', 'Pages::about');

// Authentication routes
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attempt');
$routes->post('/logout', 'Auth::logout', ['filter' => 'auth']);

// Protected customer routes
$routes->group('customers', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Customers::index');
    $routes->get('new', 'Customers::new');
    $routes->post('/', 'Customers::create');
    $routes->get('(:num)/edit', 'Customers::edit/$1');
    $routes->post('(:num)', 'Customers::update/$1');
});

// Protected user routes
$routes->group('users', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Users::index');
    $routes->get('new', 'Users::new');
    $routes->post('/', 'Users::create');
    $routes->get('(:num)/edit', 'Users::edit/$1');
    $routes->post('(:num)', 'Users::update/$1');
});