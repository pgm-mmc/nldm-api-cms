<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Data\UserData;
use App\Lib\Cryptography;

/**
 * Class UserController
 * 
 * @package \App\Controlller
 */
class UserController
{
    private $data;

    private $crypt;

    public function __construct($c)
    {
        $this->data = new UserData($c);
        $this->crypt = new Cryptography();
    }

    public function login(Request $request, Response $response)
    {
        return $response->withJson(
            ['settings' => $this->data->login()]
        );
    }

    public function register(Request $request, Response $response)
    {
        $param  = $request->getQueryParams();

        if (isset($param['username']) && isset($param['password']))
        {
            
        }
    }

    public function generatePassword(Request $request, Response $response)
    {
        $param  = $request->getQueryParams();
        $this->crypt->plainPass = $param['password'];

        return $response->withJson(
            ['password' => $this->crypt->encryptPassword()]
        );
    }

    public function verifyPassword(Request $request, Response $response)
    {
        $param  = $request->getQueryParams();
        $this->crypt->plainPass     = $param['password'];
        $this->crypt->encryptedPass = $param['encrypted_password'];

        return $response->withJson(
            ['is_valid' => $this->crypt->verifyPassword()]
        );
    }
}