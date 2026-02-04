<?php

require __DIR__ . '/../vendor/autoload.php';

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

session_start();

$dispatcher = simpleDispatcher(function (RouteCollector $r) {

    // Public
    $r->addRoute('GET', '/', ['App\Controllers\HomeController', 'index']);
    $r->addRoute('GET', '/login', ['App\Controllers\AuthController', 'loginForm']);
    $r->addRoute('POST', '/login', ['App\Controllers\AuthController', 'loginPost']);
    $r->addRoute('GET', '/logout', ['App\Controllers\AuthController', 'logout']);

    $r->addRoute('GET', '/catalog', ['App\Controllers\BookController', 'index']);
    $r->addRoute('GET', '/book/{id:\d+}', ['App\Controllers\BookController', 'detail']);

    // Member
    $r->addRoute('GET', '/dashboard', ['App\Controllers\DashboardController', 'index']);
    $r->addRoute('POST', '/reserve', ['App\Controllers\ReservationController', 'reserve']);
    $r->addRoute('POST', '/loan/borrow', ['App\Controllers\LoanController', 'borrow']);
    $r->addRoute('POST', '/loan/return', ['App\Controllers\LoanController', 'return']);

    // Admin / Librarian
    $r->addRoute('GET', '/admin', ['App\Controllers\AdminController', 'dashboard']);
    $r->addRoute('GET', '/admin/books', ['App\Controllers\AdminController', 'books']);
    $r->addRoute('GET', '/admin/books/create', ['App\Controllers\AdminController', 'createBookForm']);
    $r->addRoute('POST', '/admin/books/create', ['App\Controllers\AdminController', 'createBookPost']);
    $r->addRoute('GET', '/admin/books/edit/{id:\d+}', ['App\Controllers\AdminController', 'editBookForm']);
    $r->addRoute('POST', '/admin/books/edit/{id:\d+}', ['App\Controllers\AdminController', 'editBookPost']);
    $r->addRoute('POST', '/admin/books/delete', ['App\Controllers\AdminController', 'deleteBookPost']);

    // API
    $r->addRoute('GET', '/api/books', ['App\Controllers\ApiBooksController', 'index']);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = strtok($_SERVER['REQUEST_URI'], '?');

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo '404 - Page Not Found';
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo '405 - Method Not Allowed';
        break;

    case FastRoute\Dispatcher::FOUND:
        [$class, $method] = $routeInfo[1];
        $vars = $routeInfo[2];

        $controller = new $class();
        call_user_func_array([$controller, $method], $vars);
        break;
}
