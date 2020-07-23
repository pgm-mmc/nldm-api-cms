<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    $app->add(function ($req, $res, $next) {
        $response = $next($req, $res);
        return $response
                ->withHeader('Access-Control-Allow-Origin', $this->get('settings')['app']['cms_url'])
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

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

        $app->post('/generate/token', 'AuthController:generateToken');
    });

    $app->post('/send-mail', 'MailController:send');

    $app->group('/cms', function () use ($app) {
        $app->group('/user', function () use ($app) {
            $app->get('/get/all', 'UserController:getAll');
        });

        $app->group('/content', function () use ($app) {
            $app->get('/get/all', 'ContentController:getAll');

            $app->post('/create', 'ContentController:create');
        });

        $app->group('/section', function () use ($app) {
            $app->get('/get/all', 'SectionController:getAll');

            $app->post('/create', 'SectionController:create');
        });
    });

    $app->get('/system-info', function (Request $request, Response $response) {
        return phpinfo();
    });

    // Catch-all route to serve a 404 Not Found page if none of the routes match
    // NOTE: make sure this route is defined last
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
        $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
        return $handler($req, $res);
    });
};
