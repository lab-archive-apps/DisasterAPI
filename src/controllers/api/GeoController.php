<?php
namespace App\Controller\API;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;

use App\Models\Area\Region;
use App\Models\Area\Prefecture;
use App\Models\Area\City;
use App\Uploads\Upload;
use SplFileObject;

class GeoController extends BaseController{
    private $res = [
        'result' => 'failed',
        'state' => false,
        'error' => ''
    ];

    public function getRegion(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $regions = Region::query()->get(['id', 'name']);
        return $response->withJson($regions);
    }

    public function getPrefecture(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $region = Region::find($params->get->region_id);
        $prefectures = $region->prefectures()->get(['id', 'name']);
        return $response->withJson($prefectures);
    }

    public function getCity(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $prefecture = Prefecture::find($params->get->prefecture_id);
        $cities = $prefecture->cities()->get(['id', 'name']);
        return $response->withJson($cities);
    }

    public function getGeoJson(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $paths = [];
        // Enable Multiple params
        foreach(explode(',', $params->get->city_ids) as $key => $id){
            $city = City::find($id);
            $paths[] = [
                'name' => $city->name,
                'path' => file_get_contents($city->path)
            ];
        }
        return $response->withJson($paths);
    }

    public function postCity(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $prefecture = Prefecture::findOrFail($params->post->prefecture_id);

        $pCode = ($prefecture->id < 10) ? preg_replace("/( |　)/", "", '0' . (string)$prefecture->id): (string)$prefecture->id;

        $city = new City();
        $city->fill([
           'name' => $params->post->name,
           'name_en' => $params->post->name_en,
           'code' => $params->post->code,
           'path' => $params->path->public_path . 'geojson/' . $pCode . '/' . $params->post->code . '.json',
        ]);

        if($prefecture->cities()->save($city)){
            $this->res['result'] = 'success';
            $this->res['state'] = true;
        }

        return $response->withJson($this->res);
    }
}