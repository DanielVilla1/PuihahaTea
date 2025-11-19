<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Cart routes (customer session required via Auth/User or custom filter later)
$routes->get('/cart', 'Cart::index');
$routes->post('/cart/add', 'Cart::add');
$routes->post('/cart/item/(:num)/update', 'Cart::update/$1');
$routes->post('/cart/item/(:num)/remove', 'Cart::remove/$1');
$routes->post('/cart/checkout', 'Cart::checkout');
$routes->get('/services', 'Home::services');
$routes->get('/about', 'Home::about');
$routes->get('/contact', 'Home::contact');

// Public user auth (customer-facing)
$routes->get('/login', 'UserAuth::login');
$routes->post('/login', 'UserAuth::doLogin');
$routes->get('/register', 'UserAuth::register');
$routes->post('/register', 'UserAuth::doRegister');
// Email verification (code-based; no direct links in email)
$routes->get('/verify', 'UserAuth::verifyForm');
$routes->post('/verify', 'UserAuth::verifySubmit');
// Back-compat: token in URL still accepted but not used in emails
$routes->get('/verify/(:segment)', 'UserAuth::verify/$1');

// Customer account & session
$routes->get('/logout', 'UserAuth::logout');
$routes->get('/account', 'Account::index');
$routes->post('/account', 'Account::update');
// Customer change password
$routes->post('/account/password', 'Account::changePassword');

// Admin dashboard & CRUD for products
$routes->get('/admin', 'Admin::dashboard');
$routes->get('/admin/profile', 'Admin::profile');
$routes->post('/admin/profile/password', 'Admin::changePassword');
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
$routes->post('/admin/orders/(:num)/delete', 'Admin::deleteOrder/$1');
$routes->get('/admin/analytics', 'Admin::analytics');
$routes->get('/admin/settings', 'Admin::settings');
$routes->get('/admin/feedback', 'Admin::feedback');

// Customers dashboard (admin editable, manager view-only)
$routes->get('/admin/customers', 'Admin::customers');
$routes->get('/admin/customers/create', 'Admin::createCustomerForm');
$routes->post('/admin/customers', 'Admin::storeCustomer');
$routes->get('/admin/customers/(:num)/edit', 'Admin::editCustomerForm/$1');
$routes->post('/admin/customers/(:num)', 'Admin::updateCustomer/$1');
$routes->post('/admin/customers/(:num)/delete', 'Admin::deleteCustomer/$1');
