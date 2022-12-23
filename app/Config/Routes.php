<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

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
$routes->setAutoRoute(true);
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
$routes->get('([a-z]{2})', 'Home::index/$1');


$routes->group('{locale}', ['filter' => 'guest'], function($routes) {
        $routes->get('signup', 'Signup::getNew');
        $routes->post('signup', 'Signup::postCreate');
        $routes->get('signup/success', 'Signup::getSuccess');
        $routes->get('signup/activate/(:alphanum)', 'Signup::getActivate/$1');

    //  当get需要传入参数时的route设置。
    $routes->get('login', 'Login::getNew');
    $routes->post('login', 'Login::postCreate');
    $routes->get('password/forgot', 'Password::getForgot');
    $routes->post('password/processforgot', 'Password::postProcessForgot');
    $routes->get('password/resetsent', 'Password::getResetSent');
    $routes->get('password/reset/(:alphanum)', 'Password::getReset/$1');
    $routes->post('password/processreset/(:alphanum)', 'Password::postProcessReset/$1');
    $routes->get('password/resetsuccess', 'Password::getResetSuccess');
});

$routes->get('/logout', 'Login::getDelete');
$routes->get('/showLogoutMessage', 'Login::getShowLogoutMessage');













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
