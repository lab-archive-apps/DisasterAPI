<?php
namespace App\Controller\API;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;


class FilesController extends BaseController{
    private $res = [
        'result' => 'failed',
        'state' => false,
        'error' => ''
    ];

    /* Upload */
    public function postFile(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        return $response->withJson($this->res);
    }

    /* Temp Upload */
    public function postTempFile(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        return $response->withJson($this->res);
    }

    /* Delete File */
    public function deleteDisaster(Request $request, Response $response, $args){
        return $response->withJson($this->res);
    }
}