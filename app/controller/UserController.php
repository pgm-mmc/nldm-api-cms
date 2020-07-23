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
    private $model;

    private $crypt;

    public function __construct($c)
    {
        $this->model = new UserData($c);
        $this->crypt = new Cryptography();
    }

    public function login(Request $request, Response $response)
    {
        return $response->withJson(
            ['settings' => $this->data->login()]
        );
    }

    public function getAll(Request $request, Response $response)
    {
        $data = $this->model->getData();

        return $response->withJson(['status' => true, 'data' => $data]);
    }

    public function register(Request $request, Response $response)
    {
        $param  = $request->getQueryParams();

        if (isset($param['email']) && isset($param['password']) && isset($param['name']))
        {
            $this->model->name = $param['name'];
            $this->model->email = $param['email'];
            $this->model->password = $this->crypt->encryptPassword($param['password']);
            $this->model->isAdmin = 1;

            $status = $this->model->setData();

            return $response->withJson(['status' => $status]);
        }

        return $response->withJson(['status' => false]);
    }
}