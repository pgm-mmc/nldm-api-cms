<?php

namespace App\Controller;


use Slim\Http\Request;
use Slim\Http\Response;
use App\Data\SectionData;

/**
 * Class SectionController
 * 
 * @package \App\Controller
 */
class SectionController
{
    private $model;

    public function __construct($c)
    {
        $this->model = new SectionData($c);
    }

    public function getAll(Request $request, Response $response)
    {
        $data = $this->model->getData();

        return $response->withJson(['status' => true, 'data' => $data]);
    }

    public function create(Request $request, Response $response)
    {
        $param = $request->getQueryParams();

        if (isset($param['section_code']) && isset($param['section_desc']) && isset($param['sequence'])) {
            $this->model->sectionCode = $param['section_code'];
            $this->model->sectionDesc = $param['section_desc'];
            $this->model->sequence = $param['sequence'];
            $status = $this->model->setData();

            return $response->withJson(['status' => $status]);
        }

        return $response->withJson(['status' => false]);
    }
}