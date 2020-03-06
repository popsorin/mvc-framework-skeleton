<?php

namespace Framework;

use Framework\Contracts\ContainerInterface;
use Framework\Contracts\DispatcherInterface;
use Framework\Contracts\RouterInterface;
use Framework\Http\Request;
use Framework\Http\Response;

class Application
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Application constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param ContainerInterface $container
     * @return static
     */
    public static function create(ContainerInterface $container): self
    {
        $application =  new self($container);
        $container->set(self::class, $application);

        return $application;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $routeMatch = $this->getRouter()->route($request);

        return $this->getDispatcher()->dispatch($routeMatch, $request);
    }

    /**
     * @return RouterInterface
     */
    private function getRouter(): RouterInterface
    {
        return $this->container->get(RouterInterface::class);
    }

    /**
     * @return DispatcherInterface
     */
    private function getDispatcher(): DispatcherInterface
    {
        return $this->container->get(DispatcherInterface::class);
    }
}
