<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;
use App\Lib\Cryptography;
use App\Data\UserData;

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

    private $model;

    public function __construct($c)
    {
        $this->serverKey = $c->get('settings')['jwt']['server_key'];
        $this->expire = $c->get('settings')['jwt']['expiration'];
        $this->notBefore = $c->get('settings')['jwt']['not_before'];
        $this->app = $c->get('settings')['app'];
        $this->model = new UserData($c);
    }

    private function generateToken(): array
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
            //"nbf" => $nbf
        );

        JWT::$leeway = 5;
        $jwt = JWT::encode($payload, $this->serverKey);
        //$decoded = JWT::decode($jwt, $this->auth['server_key'], array('HS256'));

        return [
            'status' => true,
            'token_type' => 'Bearer',
            'access_token' => $jwt,
            'exp' => $exp,
            'expiration' => number_format($expiration, 2, '.', '')
        ];
    }
    
    public function login(Request $request, Response $response)
    {
        $param  = $request->getParsedBody();

        if (isset($param['email']) && isset($param['password'])) {
            $this->model->email = $param['email'];
            $this->model->password = $param['password'];

            $verify = $this->model->login();

            if ($verify) {
                $securePass = $this->model->getPassword();

                $crypt = new Cryptography();

                if ($crypt->verifyPassword($this->model->password, $securePass)) {
                    return $response->withJson($this->generateToken());
                }

            }
        }

        return $response->withJson(['status' => false, 'payload' => $param]);
    }
}