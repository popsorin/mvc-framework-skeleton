<?php
$baseDir = dirname(__DIR__);
require $baseDir.'/vendor/autoload.php';
use Framework\Router\Router;
use Framework\Http\Request;

$configuration = require '../config/routerConfig.php';
//use Framework\Application;
//use Framework\Http\Request;
/*
// obtain the DI container
$container = require $baseDir.'/config/services.php';

// create the application and handle the request
$application = Application::create($container);
$request = Request::createFromGlobals();
$response = $application->handle($request);
$response->send();*/

$router = new Router($configuration);
$request =  new Request();
$match = $router->route($request);

echo $match->getMethod() . PHP_EOL . $match->getControllerName() . PHP_EOL .$match->getActionName() . PHP_EOL ;
print_r($match->getRequestAttributes());
