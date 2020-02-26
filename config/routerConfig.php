<?php

use Framework\Router\Router;


//nu putem configura si router si dispacher ??
return [
    Router::CONFIG_KEY_DISPATCHER => [Router::CONFIG_KEY_NAMESPACE => 'Framework/Controller',
                                      Router::CONFIG_KEY_SUFFIX => 'Controller'],
    Router::CONFIG_KEY_ROUTER =>[
    'user_controller_add' =>
    [
        Router::CONFIG_KEY_PATH => '/user/add',
        Router::CONFIG_KEY_CONTROLLER_NAME => 'user',
        Router::CONFIG_KEY_ACTION  => 'add',
        Router::CONFIG_KEY_METHOD => 'POST'
    ],
    'user_controller_set' =>
    [
        Router::CONFIG_KEY_PATH => '/user/(?<id>1|2)/set/(?<role>1|2|3)',
        Router::CONFIG_KEY_CONTROLLER_NAME => '/user',
        Router::CONFIG_KEY_ACTION => 'update',
        Router::CONFIG_KEY_METHOD => 'POST'
    ]
    ]
];