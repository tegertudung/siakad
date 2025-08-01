<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// akses base url,siapapun yang akses baseurl maka diarahkan ke Controller Home fungsi index
// $routes->get('/', 'Home::index');

// akses base url,siapapun yang akses baseurl maka diarahkan ke Controller Auth fungsi index
$routes->get('/', 'Auth\Login::index', ['filter' => 'cek_percobaan_login']);
$routes->post('/trxlogin', 'Auth\Login::eseclogin', ['filter' => 'cek_percobaan_login']);

$routes->get('/locked', 'Auth\Login::locked');
