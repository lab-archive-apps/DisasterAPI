<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Controller of Visualize System
 * Class StaffController
 * @package App\Controller
 */
class StaffController extends BaseController {


    public function top(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        return $this->view->render($response, '/staff/top.twig', [
            'params' => $params,
        ]);
    }

    public function index(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');


        return $this->view->render($response, '/staff/index.twig', [
            'params' => $params,
        ]);
    }
}