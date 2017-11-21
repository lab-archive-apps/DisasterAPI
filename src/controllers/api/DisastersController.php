<?php

namespace App\Controller\API;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;
use App\Models\Disaster;
use App\Search\DisasterSearch;
use App\Models\DisasterContent as Content;

class DisastersController extends BaseController {

    /* Get disasters name, season, class */
    public function getDisasters(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        $query = new DisasterSearch(Disaster::query(), $params->get);
        $disasters = $query->search();

        return $disasters;
    }

    /* Get disaster with corresponds */
    public function getDisaster(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        // TODO: not use find(), because it if returned "[]", slim3 would call "500 error".
        $disasters = Disaster::query()
            ->where('id', $params->get->disasterId)
            ->with(['corresponds', 'coordinates'])
            ->first()->toJson();
        return $disasters;
    }

    /* Post disaster */
    public function postDisaster(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        return json_encode(['result' => 'success']);
    }

    /* Post disaster */
    public function Disaster(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        return json_encode(['result' => 'success']);
    }

    /* Post disaster */
    public function updateDisaster(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        return json_encode(['result' => 'success']);
    }
}