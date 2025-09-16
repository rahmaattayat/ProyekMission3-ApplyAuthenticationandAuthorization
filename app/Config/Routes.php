<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

// auth routes
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attempt');
$routes->get('/logout', 'Auth::logout');

// admin group
$routes->group('admin', ['filter' => 'role:admin'], static function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');

    // Courses CRUD
    $routes->get('courses',              'Course::index');
    $routes->get('courses/new',          'Course::new');
    $routes->post('courses',             'Course::create');
    $routes->get('courses/(:num)/edit',  'Course::edit/$1');
    $routes->post('courses/(:num)',      'Course::update/$1');
    $routes->get('courses/(:num)/delete','Course::delete/$1');

    // Students CRUD
    $routes->get('students',               'Student::index');
    $routes->get('students/new',           'Student::new');
    $routes->post('students',              'Student::create');
    $routes->get('students/(:num)',        'Student::show/$1'); 
    $routes->get('students/(:num)/edit',   'Student::edit/$1');
    $routes->post('students/(:num)',       'Student::update/$1');
    $routes->get('students/(:num)/delete', 'Student::delete/$1');
});

// student group
$routes->group('student', ['filter' => 'role:student'], static function($routes) {
    // Dashboard
    $routes->get('dashboard', 'StudentArea::dashboard');

    // Enroll
    $routes->get('enroll', 'Enroll::index');
    $routes->post('enroll/(:num)', 'Enroll::store/$1');
    $routes->post('enroll/(:num)/drop', 'Enroll::drop/$1');
});
