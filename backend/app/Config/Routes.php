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
$routes->get('/admin/products', 'Admin::products');
$routes->post('/admin/products', 'Admin::createProduct');
$routes->post('/admin/products/(:num)', 'Admin::updateProduct/$1');
$routes->post('/admin/products/(:num)/delete', 'Admin::deleteProduct/$1');

// Auth
$routes->get('/admin/login', 'Auth::login');
$routes->post('/admin/login', 'Auth::doLogin');
$routes->get('/admin/logout', 'Auth::logout');

// Admin users management
$routes->get('/admin/users/create', 'Admin::createUserForm');
$routes->get('/admin/users/(:num)/edit', 'Admin::editUserForm/$1');
$routes->post('/admin/users', 'Admin::storeUser');
$routes->post('/admin/users/(:num)', 'Admin::updateUser/$1');
$routes->post('/admin/users/(:num)/delete', 'Admin::deleteUser/$1');

// Admin extra pages
$routes->get('/admin/audit-logs', 'Admin::auditLogs');
$routes->get('/admin/ingredients', 'Admin::ingredients');
$routes->get('/admin/suppliers', 'Admin::suppliers');
$routes->get('/admin/orders', 'Admin::orders');
$routes->post('/admin/orders', 'Admin::createOrder');
$routes->post('/admin/orders/(:num)/status', 'Admin::updateOrderStatus/$1');
$routes->get('/admin/analytics', 'Admin::analytics');
$routes->get('/admin/settings', 'Admin::settings');
$routes->get('/admin/feedback', 'Admin::feedback');
