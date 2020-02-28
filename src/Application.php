<?php

namespace Framework;

use Exception;
use Framework\Contracts\ContainerInterface;
use Framework\Contracts\DispatcherInterface;
use Framework\Contracts\RouterInterface;
use Framework\Dispatcher\Dispatcher;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Router\Router;
use Framework\Routing\RouteMatch;

class Application
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function create(ContainerInterface $container): self
    {
        $application =  new self($container);
        $container->set(self::class, $application);

        return $application;
    }

    public function handle(Request $request): Response
    {
        $routeMatch = $this->getRouter()->route($request);

        return $this->getDispatcher()->dispatch($routeMatch, $request);
    }

    private function getRouter(): RouterInterface
    {
        return $this->container->get(RouterInterface::class);
    }

    private function getDispatcher(): DispatcherInterface
    {
        return $this->container->get(DispatcherInterface::class);
    }
}
