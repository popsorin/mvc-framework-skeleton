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

    /**
     * RouteMatch constructor.
     * @param string $method
     * @param string $controllerName
     * @param string $action
     * @param array $requestAttributes
     */
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

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        return $this->action;
    }

    /**
     * @return array
     */
    public function getRequestAttributes(): array
    {
        return $this->requestAttributes;
    }
}
