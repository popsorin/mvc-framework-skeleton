<?php

namespace Framework\Routing;

class RouteMatch
{
    /**
     * @var string
     */
    private $method;
    /**
     * @var string
     */
    private $controllerName;
    /**
     * @var string
     */
    private $action;
    /**
     * @var array
     */
    private $requestAttributes;


    public function __construct
    (
        string $method,
        string $controllerName,
        string $action,
        array  $requestAttributes
    ) {
        $this->method = $method;
        $this->controllerName = $controllerName;
        $this->action = $action;
        $this->requestAttributes = $requestAttributes;
    }
    public function getMethod(): string
    {
        return $this->method;
    }

    public function getControllerName(): string
    {
        return $this->controllerName;
    }


    public function getActionName(): string
    {
        return $this->action;
    }


    public function getRequestAttributes(): array
    {
        return $this->requestAttributes;
    }
}
