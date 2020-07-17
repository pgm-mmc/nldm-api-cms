<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

/**
 * Class AuthController
 * 
 * @package \App\Controller
 */
class AuthController
{
    private $serverKey;

    private $expire;

    private $notBefore;

    private $app;

    public function __construct($c)
    {
        $this->serverKey = $c->get('settings')['jwt']['server_key'];
        $this->expire = $c->get('settings')['jwt']['expiration'];
        $this->notBefore = $c->get('settings')['jwt']['not_before'];
        $this->app = $c->get('settings')['app'];
    }

    public function generateToken(Request $request, Response $response)
    {
        // Set Expiration Time
        $issuedAt   = time();
        $nbf        = $issuedAt + $this->notBefore;    // Adding *seconds
        $exp        = $nbf + $this->expire;            // Adding *seconds
        $expiration = ($this->expire + $this->notBefore) / 60;

        $payload = array(
            "iss" => $this->app['app_url'],
            "aud" => $this->app['cms_url'],
            "exp" => $exp,
            "nbf" => $nbf
        );

        $jwt = JWT::encode($payload, $this->serverKey);
        //$decoded = JWT::decode($jwt, $this->auth['server_key'], array('HS256'));

        return $response->withJson([
            'token_type' => 'Bearer',
            'access_token' => $jwt,
            'exp' => $exp,
            'expiration' => number_format($expiration, 2, '.', '')
        ]);
    }
}