<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Data\ContentData;

/**
 * Class ContentController
 * 
 * @package \App\Controller
 */
class ContentController
{
    private $model;

    public function __construct($c)
    {
        $this->model = new ContentData($c);
    }

    public function getAll(Request $request, Response $response)
    {
        $data = $this->model->getData();

        return $response->withJson(['status' => true, 'data' => $data]);
    }
}