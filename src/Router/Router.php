<?php

namespace Framework\Router;

use Framework\Contracts\RouterInterface;
use Framework\Http\Request;
use Framework\Routing\RouteMatch;

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
            $value['URI'] = preg_replace('/\//', '\/', $value['URI']);
            $requestMethod = $request->getMethod();
            $requestPath = $request->getPath();
            $requestAttributes = array();
            //search in the configuration array for the same URI and the same
            //Method as the ones from the request
            if(preg_match('/' . $value['URI'] . '/', $requestPath) && $value['Method']  === $requestMethod) {
               preg_match_all('/\d+/', $requestPath, $requestAttributes);
                    return new RouteMatch(
                        $request->getMethod(),
                        $value['ControllerName'],
                        $value['Action'],
                        $requestAttributes);
            }
        }
    }
}