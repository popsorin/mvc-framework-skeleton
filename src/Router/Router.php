<?php

namespace Framework\Router;

use Framework\Contracts\RouterInterface;
use Framework\Http\Request;
use Framework\Routing\RouteMatch;
use Framework\Exceptions\PathNotFoundException;
use const Framework\config\CONFIG_KEY_ACTION;
use const Framework\config\CONFIG_KEY_CONTROLLER_NAME;
use const Framework\config\CONFIG_KEY_METHOD;
use const Framework\config\CONFIG_KEY_PATH;

class Router implements RouterInterface
{
    /**
     * @var array
     */
    private $configuration;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    public function route(Request $request): RouteMatch
    {
        foreach ($this->configuration as $key=>$value) {
            //replace all the '/' with '\/' in the URI from the configuration
            $value[CONFIG_KEY_PATH] = preg_replace('/\//', '\/', $value[CONFIG_KEY_PATH]);
            $requestMethod = $request->getMethod();
            $requestPath = $request->getPath();
            $requestAttributes = array();
            //search in the configuration array for the same path and the same
            //method as the ones from the request
            if(preg_match('/' . $value[CONFIG_KEY_PATH] . '/', $requestPath, $requestAttributes) && $value[CONFIG_KEY_METHOD]  === $requestMethod) {
             //deletes the keys with numerical value
                    $requestAttributes = array_filter($requestAttributes,function ($variable) {
                            return !is_int($variable);
                    }, ARRAY_FILTER_USE_KEY);
                    return new RouteMatch(
                        $request->getMethod(),
                        $value[CONFIG_KEY_CONTROLLER_NAME],
                        $value[CONFIG_KEY_ACTION],
                        $requestAttributes
                    );
            }
        }

        throw new PathNotFoundException();
    }
}