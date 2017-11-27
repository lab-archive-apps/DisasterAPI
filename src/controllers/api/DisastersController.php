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

        // TODO: not use find(), because if $disasters returned "[]", slim3 would call "500 error".
        $disasters = Disaster::query()
            ->where('id', $params->get->disasterId)
            ->with(['corresponds', 'coordinates'])
            ->first()->toJson();
        return $disasters;
    }

    /* Post disaster */
    public function postDisaster(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
//
//        $disaster = new Disaster();
//        $disaster->fill(json_decode(json_encode($params->post->disaster), true));

        $response = ['result' => 'failed', 'date' => $params->post->date];

//        if($disaster->save()){
//            $response['result'] = 'success';
//        }
//            $coordinates = [];
//            foreach($params->post->disaster->coordinates as $key => $value){
//                $coordinate = new DisasterCoordinate();
//                $coordinate->fill(json_decode(json_encode($value), true));
//                $coordinates[] = $coordinate;
//            }
//            $disaster->coordinates()->saveMany($coordinates);

        return json_encode(compact('response'));
    }

    /* Update disaster */
    public function updateDisaster(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $disaster = Disaster::find($args['disasterId']);

        $response = ['result' => 'failed'];

        if($disaster->update(json_decode(json_encode($params->post->disaster), true)))
            $response['result'] = 'success';

        return json_encode(compact('response'));
    }

    /* Delete disaster */
    public function deleteDisaster(Request $request, Response $response, $args){
        $disaster = Disaster::find($args['disasterId']);

        $response = ['result' => 'failed'];

        if($disaster->delete())
            $response['result'] = 'success';

        return json_encode(compact('response'));
    }
}