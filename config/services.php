<?php

use Framework\Contracts\DispatcherInterface;
use Framework\Contracts\RendererInterface;
use Framework\Contracts\RouterInterface;
use Framework\Controller\AbstractController;
use Framework\Controller\UserController;
use Framework\DependencyInjection\SymfonyContainer;
use Framework\Dispatcher\Dispatcher;
use Framework\Renderer\Renderer;
use Framework\Router\Router;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

$container = new ContainerBuilder();
$config = require "../config/config.php";

$container->setParameter('routerConfig', $config[Router::CONFIG_KEY_ROUTER]);
$container->register(RouterInterface::class, Router::class)
            ->addArgument('%routerConfig%');

$baseViewPath = __DIR__ . '/../src/views';
$container->setParameter("baseViewPath", $baseViewPath);
$container->register(RendererInterface::class, Renderer::class)
    ->addArgument('%baseViewPath%');

$container->register(UserController::class, UserController::class)
            ->addArgument(new Reference(RendererInterface::class));

$container->setParameter('dispatcherConfig', $config[Dispatcher::CONFIG_KEY_DISPATCHER]);
$container->register(DispatcherInterface::class, Dispatcher::class)
           ->addArgument('%dispatcherConfig')
           ->addMethodCall('addController', [new Reference(UserController::class)]);

return new SymfonyContainer($container);