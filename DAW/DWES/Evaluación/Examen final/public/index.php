<?php
require_once '../App/Config/config.php';
require_once '../App/Core/Router.php';

spl_autoload_register(function ($className) {
    $className = str_replace('\\', '/', $className);
    require_once '../App/' . $className . '.php';
});

use Controller\IndexController;

$router = new Router();
$router->add(array(
    'name' => 'home',
    'path' => '/^\/$/',
    'action' => [IndexController::class, 'IndexAction']
));
$request = str_replace(DIRBASEURL, '', $_SERVER['REQUEST_URI']);
$route = $router->match($request);
if ($route) {
    $controllerName = $route['action'][0];
    $actionName = $route['action'][1];
    $controller = new $controllerName;
    $controller->$actionName($request);
} else {
    echo "No route";
}
header('Location: ' . '..\views\index_view.php');

