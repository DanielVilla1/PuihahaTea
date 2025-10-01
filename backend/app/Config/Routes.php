<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/services', 'Home::services');
$routes->get('/about', 'Home::about');
$routes->get('/contact', 'Home::contact');

// Admin dashboard & CRUD for products
$routes->get('/admin', 'Admin::dashboard');
$routes->post('/admin/products', 'Admin::createProduct');
$routes->post('/admin/products/(:num)', 'Admin::updateProduct/$1');
$routes->post('/admin/products/(:num)/delete', 'Admin::deleteProduct/$1');
