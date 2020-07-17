<?php

use Slim\App;

return function (App $app) {

    $container = $app->getContainer();

    /**
     * Controller
     */

    // AuthController
    $container['AuthController'] = function ($c) use ($container) {
        return new \App\Controller\AuthController($container);
    };

    // UserController
    $container['UserController'] = function ($c) use ($container) {
        return new \App\Controller\UserController($container);
    };

     // MailController
     $container['MailController'] = function ($c) use ($container) {
        return new \App\Controller\MailController($container);
    };

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };
};
