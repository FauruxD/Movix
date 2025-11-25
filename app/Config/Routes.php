<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::login');

$routes->group('auth', function($routes) {
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::processRegister');
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::processLogin');
    $routes->get('logout', 'Auth::logout');
});

$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('kelolafilm', 'Admin::kelolafilm');
    $routes->get('kelolauser', 'Admin::kelolauser');
    $routes->post('tambah-film', 'Admin::tambahFilm');
    $routes->get('delete-film/(:num)', 'Admin::deleteFilm/$1');
    $routes->get('delete-user/(:num)', 'Admin::deleteUser/$1');
});

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Home::dashboard');
    $routes->get('film/(:num)', 'Home::watchFilm/$1');
});
$routes->group('favorite', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Favorite::index');                    
    $routes->post('toggle', 'Favorite::toggle');              
    $routes->post('check-status', 'Favorite::checkStatus');  
});

$routes->group('watch', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Watch::index');                        
    $routes->get('player/(:num)', 'Watch::player/$1');        
    $routes->post('toggle', 'Watch::toggle');                 
    $routes->post('mark-watched', 'Watch::markWatched');     
    $routes->post('check-status', 'Watch::checkStatus');      
});