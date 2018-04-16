<?php
namespace App\Controller\API;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;
use App\Models\Storage\Disaster;
use App\Search\DisasterSearch;

/**
 * Control a Disaster info
 * Class DisastersController
 * @package App\Controller\API
 */
class DisastersController extends BaseController{
    /* Get disasters */
    public function getDisasters(Request $request, Response $response, $args)
    {
        $params = $request->getAttribute('params');

        $query = new DisasterSearch(Disaster::query(), $params->get);
        $disasters = $query->search();

        return $response->withJson($disasters);
    }

    /* Get disaster with corresponds */
    public function getDisaster(Request $request, Response $response, $args)
    {
        $params = $request->getAttribute('params');

        $disaster = Disaster::query()->find($params->get->disaster_id);
        return $response->withJson($disaster);
    }

    /* Post disaster */
    public function postDisaster(Request $request, Response $response, $args)
    {
        $params = $request->getAttribute('params');

        $disaster = new Disaster();
        $disaster->fill([
            'date' => $params->post->date,
            'name' => $params->post->name,
            'season' => $params->post->season,
            'area' => isset($params->post->area) ? $params->post->area : '',
            'prefecture' => isset($params->post->prefecture) ? $params->post->prefecture : '',
            'city' => isset($params->post->city) ? $params->post->city : '',
            'classification' => $params->post->classification,
            'scale' => '',
        ]);

        if ($disaster->save()) {
            $this->res['result'] = 'success';
            $this->res['state'] = true;
            $this->res['id'] = $disaster->id;
        }else{
            $this->res['error'] = '登録に失敗しました．';
        }
//            $coordinates = [];
//            foreach($params->post->disaster->coordinates as $key => $value){
//                $coordinate = new DisasterCoordinate();
//                $coordinate->fill(json_decode(json_encode($value), true));
//                $coordinates[] = $coordinate;
//            }
//            $disaster->coordinates()->saveMany($coordinates);
        return $response->withJson($this->res);
    }

    /* Update disaster */
    public function updateDisaster(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $disaster = Disaster::find($params->post->disaster_id);
        $data = [
            'date' => $params->post->date,
            'name' => $params->post->name,
            'season' => $params->post->season,
            'area' => $params->post->area,
            'prefecture' => $params->post->prefecture,
            'city' => $params->post->city,
            'classification' => $params->post->classification,
            'scale' => $params->post->scale,
        ];

        if ($disaster->update($data)){
            $this->res['result'] = 'success';
            $this->res['state'] = true;
        }else {
            $this->res['error'] = '更新に失敗しました．';
        }

        return $response->withJson($this->res);
    }

    /* Delete disaster */
    public function deleteDisaster(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $disaster = Disaster::find($params->post->id);

        if ($disaster->delete()) {
            $this->res['result'] = 'success';
            $this->res['state'] = true;
        }else {
            $this->res['error'] = '削除に失敗しました．';
        }
        return $response->withJson($this->res);
    }

    /* Get a count of saved disaster info for each year or month. */
    public function getLatestDisaster(Request $request, Response $response, $args) {
        $params = $request->getAttribute('params');

        $query = new DisasterSearch(Disaster::query(), $params->get);
        $latestDisasters = $query->getLatestCount();

        return $response->withJson($latestDisasters);
    }
}