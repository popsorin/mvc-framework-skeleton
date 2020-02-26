<?php

namespace Framework\config;

return array(
'user_controller_add' =>
    [
        'URI' => '/user/add',
        'ControllerName' => 'Framework/Controller/UserController',
        'Action' => 'add',
        'Method' => 'POST'
    ],
'user_controller_set' =>
    [
        'URI' => '/user/\d+/set/\d+',
        'ControllerName' => 'Framework/Controller/UserController',
        'Action' => 'add',
        'Method' => 'POST'
    ]
);