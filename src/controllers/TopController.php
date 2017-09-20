<?php
/**
 * Created by PhpStorm.
 * User: tatsuya
 * Date: 2017/08/03
 * Time: 12:04
 */

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Disaster;

class TopController extends BaseController {

    public function index(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $disaster = Disaster::query()
            ->orderBy('updated_at', 'desc')
            ->with(['corresponds', 'coordinates'])
            ->first();

        return $this->view->render($response, '/top.twig', [
            'params' => $params,
            'disaster' => $disaster
        ]);
    }
}