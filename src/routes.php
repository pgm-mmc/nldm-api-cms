<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

    $app->group('/user', function () use ($app) {
        $app->post('/register', 'UserController:register');
    });

    $app->group('/auth', function () use ($app) {
        $app->post('/login', 'UserController:login');

        $app->post('/generate/password', 'UserController:generatePassword');

        $app->post('/verify/password', 'UserController:verifyPassword');

        $app->post('/generate/token', 'AuthController:generateToken');
    });

    $app->post('/send-mail', 'MailController:send');

    $app->get('/system-info', function (Request $request, Response $response) {
        return phpinfo();
    });
};
