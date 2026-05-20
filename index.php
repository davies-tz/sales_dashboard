<?php
/**
 * Front Controller — MVC Entry Point
 * All requests route through here via .htaccess
 */

require_once dirname(__DIR__) . '/config/app.php';

// Parse the URI
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Strip base path if app is in a subdirectory
// Adjust 'sales_dashboard/public' to match your actual path
$base = 'sales_dashboard/public';
if (strpos($uri, $base) === 0) {
    $uri = trim(substr($uri, strlen($base)), '/');
}

$parts  = explode('/', $uri);
$controller = $parts[0] ?? '';
$action     = $parts[1] ?? 'index';

// Route Map
$routes = [
    ''          => ['DashboardController', 'index'],
    'dashboard' => ['DashboardController', 'index'],
    'sales'     => ['SalesController', 'index'],
    'products'  => ['ProductsController', 'index'],
    'customers' => ['CustomersController', 'index'],
];

// CRUD actions
$crudRoutes = [
    'sales/create'      => ['SalesController',     'create'],
    'sales/delete'      => ['SalesController',     'delete'],
    'products/create'   => ['ProductsController',  'create'],
    'products/delete'   => ['ProductsController',  'delete'],
    'customers/create'  => ['CustomersController', 'create'],
    'customers/delete'  => ['CustomersController', 'delete'],
];

$path = trim($controller . '/' . $action, '/');

if (isset($crudRoutes[$path])) {
    [$class, $method] = $crudRoutes[$path];
} elseif (isset($routes[$controller])) {
    [$class, $method] = $routes[$controller];
} else {
    http_response_code(404);
    echo '<h1 style="font-family:sans-serif;color:#fff;padding:40px;background:#0D1117;min-height:100vh;margin:0">404 — Page not found</h1>';
    exit;
}

// Instantiate controller and call method
$ctrl = new $class();
$ctrl->$method();
