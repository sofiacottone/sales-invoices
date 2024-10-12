<?php

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . 'Core/functions.php';

// autoload called classes
// instead of adding `require base_path('Core/Class.php');` for each class
spl_autoload_register((function ($class) {
    // replace backslash with current OS directory separator (current: '/')
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    // require the file of the called class
    require base_path($class . '.php');
}));

// create a new Router instance
$router = new \Core\Router();

$routes = require base_path('routes.php');

// get current uri path
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

// get form method 
// use custom method in case of PUT, PATCH, DELETED methods
// or get the method from the server info
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->routeToController($uri, $method);
