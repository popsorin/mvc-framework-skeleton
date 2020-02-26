<?php
$baseDir = dirname(__DIR__);
require $baseDir.'/vendor/autoload.php';

use Framework\Exceptions\PathNotFoundException;
use Framework\Router\Router;
use Framework\Http\Request;
ini_set("display_errors",1);

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
try {
    $match = $router->route($request);
    echo " Method:" . $match->getMethod() . "<br>" .
    " Controller:" . $match->getControllerName() . "<br>" .
    " Action:" . PHP_EOL .$match->getActionName() . "<br>";
print_r($match->getRequestAttributes());
}
catch (PathNotFoundException $exception) {
    echo $exception->getMessage();
}