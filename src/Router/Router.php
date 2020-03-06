<?php

namespace Framework\Router;

use Framework\Contracts\RouterInterface;
use Framework\Http\Request;
use Framework\Routing\RouteMatch;
use Framework\Exceptions\PathNotFoundException;

class Router implements RouterInterface
{
    public const CONFIG_KEY_ROUTER = 'router';
    public const CONFIG_KEY_PATH = 'path';
    public const CONFIG_KEY_CONTROLLER_NAME = 'ControllerName';
    public const CONFIG_KEY_ACTION = 'Action';
    public const CONFIG_KEY_METHOD = 'Method';
    
    /**
     * @var array
     */
    private $configuration;

    /**
     * Router constructor.
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param Request $request
     * @return RouteMatch
     * @throws PathNotFoundException
     */
    public function route(Request $request): RouteMatch
    {
        $method = $request->getMethod();
        $requestPath = $request->getUri()->getPath();

        foreach ($this->configuration as $key => $value) {
            if($value[self::CONFIG_KEY_METHOD]  !== $method) {
                continue;
            }

            $path =$this->preparePath($value[(self::CONFIG_KEY_PATH)]);

            //Search in the configuration array for the same path and the same method as the ones from the request
            $requestAttributes = [];
            if(preg_match($path, $requestPath, $requestAttributes)) {
             //Deletes the keys with numerical value preg_match gives numerical and string keys so i need to delete the numerical ones
                $requestAttributes = $this->filter($requestAttributes);
                return new RouteMatch
                (
                    $request->getMethod(),
                    $value[self::CONFIG_KEY_CONTROLLER_NAME],
                    $value[self::CONFIG_KEY_ACTION],
                    $requestAttributes
                );
            }
        }

        throw new PathNotFoundException($requestPath);
    }

    /**
     * @param $path
     * @return string
     */
    //replace all the '/' with '\/' in the Uri from the configuration
    private function preparePath($path)
    {
        $value[$path] = preg_replace('/\//', '\/', $path);

        return '/' . $value[$path] . '/';
    }

    /**
     * @param array $requestAttributes
     * @return array
     */
    private function filter(array $requestAttributes)
    {
        return array_filter($requestAttributes,function ($variable) {
            return !is_int($variable);
        }, ARRAY_FILTER_USE_KEY);
    }
}