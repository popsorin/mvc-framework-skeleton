<?php

namespace Framework\Router;

use Framework\Contracts\RouterInterface;
use Framework\Http\Request;
use Framework\Routing\RouteMatch;
use Framework\Exceptions\PathNotFoundException;

class Router implements RouterInterface
{
    public const CONFIG_KEY_DISPATCHER = 'dispatcher';
    public const CONFIG_KEY_ROUTER = 'router';
    public const CONFIG_KEY_NAMESPACE = 'controller_namespace';
    public const CONFIG_KEY_SUFFIX = 'suffix';
    public const CONFIG_KEY_PATH = 'path';
    public const CONFIG_KEY_CONTROLLER_NAME = 'ControllerName';
    public const CONFIG_KEY_ACTION = 'Action';
    public const CONFIG_KEY_METHOD = 'Method';

    /**
     * @var array
     */
    private $configuration;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration['router'];
    }

    public function route(Request $request): RouteMatch
    {
        foreach ($this->configuration as $key=>$value) {
            $method = $request->getMethod();

            $config = $value[self::CONFIG_KEY_METHOD];
            if($value[self::CONFIG_KEY_METHOD]  !== $method) {
                continue;
            }
            //replace all the '/' with '\/' in the URI from the configuration
            $path =self::preparePath($value[self::CONFIG_KEY_PATH]);
            $requestAttributes = [];
            //search in the configuration array for the same path and the same
            //method as the ones from the request
            if(preg_match($path, $request->getPath(), $requestAttributes)) {
             //deletes the keys with numerical valuef
                    $requestAttributes = array_filter($requestAttributes,function ($variable) {
                            return !is_int($variable);
                    }, ARRAY_FILTER_USE_KEY);
                    return new RouteMatch(
                        $request->getMethod(),
                        $value[self::CONFIG_KEY_CONTROLLER_NAME],
                        $value[self::CONFIG_KEY_ACTION],
                        $requestAttributes
                    );
            }
        }

        throw new PathNotFoundException();
    }

    //
    private static function preparePath($path)
    {
        $value[$path] = preg_replace('/\//', '\/', $path);

        return '/' . $value[$path] . '/';
    }
}