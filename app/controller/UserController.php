<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Data\UserData;

/**
 * Class UserController
 * 
 * @package \App\Controlller
 */
class UserController
{
    private $data;

    public function __construct($c)
    {
        $this->data = new UserData($c);
    }

    public function login(Request $request, Response $response)
    {
        return $response->withJson(
            ['settings' => $this->data->login()]
        );
    }

    public function register(Request $request, Response $response)
    {
        
    }
}