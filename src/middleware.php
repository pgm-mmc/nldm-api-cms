<?php

use Slim\App;

return function (App $app) {
    // e.g: $app->add(new \Slim\Csrf\Guard);

    $container = $app->getContainer();

    $app->add(new Tuupola\Middleware\JwtAuthentication([
        "ignore" => ["/auth", "/send-mail"],
        "secret" => $container->get('settings')['jwt']['server_key'],
        "error" => function ($response, $arguments) {
            $data["status"] = "error";
            $data["message"] = $arguments["message"];
            return $response
                ->withHeader("Content-Type", "application/json")
                ->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
    ]));
};
