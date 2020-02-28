<?php

namespace Framework\Dispatcher;

use Framework\Config\Config;
use Framework\Contracts\DispatcherInterface;
use Framework\Controller\AbstractController;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\Stream;
use Framework\Routing\RouteMatch;

class Dispatcher implements DispatcherInterface
{
    public const CONFIG_KEY_DISPATCHER = 'dispatcher';
    public const CONFIG_KEY_NAMESPACE = 'controller_namespace';
    public const CONFIG_KEY_SUFFIX = 'suffix';

    /**
     * @var array
     */
    private $controllerList;

    /**
     * @var
     */
    private $configuration;

    public function __construct(array $configuration)
    {
       $this->configuration = $configuration;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(RouteMatch $routeMatch, Request $request): Response
    {
        $fullyQualifiedName = "{$this->configuration[self::CONFIG_KEY_NAMESPACE]}\\{$routeMatch->getControllerName()}{$this->configuration[self::CONFIG_KEY_SUFFIX]}";

        if (!isset($this->controllerList[$fullyQualifiedName]) || !method_exists($this->controllerList[$fullyQualifiedName], $routeMatch->getActionName())) {
            //MAKE!! a controllerNotFound exception
            $stream = Stream::createFromString("BAD!!!!");
            $response = new Response($stream);
            $response->withStatus("404");

            return $response;
        }

        return call_user_func_array([$this->controllerList[$fullyQualifiedName], $routeMatch->getActionName()], [$request, $routeMatch->getRequestAttributes()]);
    }

    public function addController(AbstractController $controller)
    {
        $this->controllerList[get_class($controller)] = $controller;
    }
}