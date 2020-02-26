<?php

namespace Framework\config;

const CONFIG_KEY_PATH = 'path';
const CONFIG_KEY_CONTROLLER_NAME = 'ControllerName';
const CONFIG_KEY_ACTION = 'Action';
const CONFIG_KEY_METHOD = 'Method';
const CONTROLLER_NAMESPACE = 'Framework/Controller';
const SUFFIX = 'Controller';
const USER_ALIAS ='id';
const SET_ALIAS ='id';

return array(
'user_controller_add' =>
    [
        CONFIG_KEY_PATH => '/user/add',
        CONFIG_KEY_CONTROLLER_NAME => CONTROLLER_NAMESPACE . '/User'.SUFFIX,
        CONFIG_KEY_ACTION  => 'add',
        CONFIG_KEY_METHOD => 'POST'
    ],
'user_controller_set' =>
    [
        CONFIG_KEY_PATH => '/user/(?<id>1|2)/set/(?<role>1|2|3)',
        CONFIG_KEY_CONTROLLER_NAME => CONTROLLER_NAMESPACE . '/User'.SUFFIX,
        CONFIG_KEY_ACTION => 'update',
        CONFIG_KEY_METHOD => 'PUT'
    ]
);