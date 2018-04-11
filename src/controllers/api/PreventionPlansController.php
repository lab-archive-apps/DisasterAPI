<?php

namespace App\Controller\API;

use App\Models\File;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;
use App\Search\PreventionPlanSearch;
use App\Models\Storage\PreventionPlan;
use App\Uploads\Upload;

class PreventionPlansController extends BaseController{
    /* Get preventionPlans */
    public function getPreventionPlans(Request $request, Response $response, $args)
    {
        $params = $request->getAttribute('params');

        $query = new PreventionPlanSearch(PreventionPlan::query(), $params->get);
        $preventionPlans = $query->search();

        return $response->withJson($preventionPlans);
    }

    /* Get preventionPlan with corresponds */
    public function getPreventionPlan(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        $preventionPlan = PreventionPlan::findOrFail($params->get->plan_id);
        $preventionPlan['uploads'] = $preventionPlan->uploads;
        return $response->withJson($preventionPlan);
    }

    /* Post preventionPlan */
    public function postPreventionPlan(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        $preventionPlan = new PreventionPlan();
        $preventionPlan->fill([
            'name' => $params->post->name,
            'location' => $params->post->location,
            'classification' => $params->post->classification
        ]);

        if ($preventionPlan->save()) {
            $this->uploadFiles($params, $preventionPlan);
            $this->res['result'] = 'success';
            $this->res['state'] = true;
        }else{
            $this->res['error'] = 'Failed Register.';
        }

        return $response->withJson($this->res);
    }

    /* Update preventionPlan */
    public function updatePreventionPlan(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $preventionPlan = PreventionPlan::find($params->post->plan_id);
        $data = [
            'name' => $params->post->name,
            'location' => $params->post->location,
            'classification' => $params->post->classification
        ];

        if ($preventionPlan->update($data)){
            $this->uploadFiles($params, $preventionPlan);
            $this->res['result'] = 'success';
            $this->res['state'] = true;
        }else {
            $this->res['error'] = '更新に失敗しました．';
        }

        return $response->withJson($this->res);
    }

    /* Delete preventionPlan */
    public function deletePreventionPlan(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $preventionPlan = PreventionPlan::find($params->post->plan_id);

        foreach ($preventionPlan->uploads as $fKey => $f) {
            if (file_exists($f->path)) {
                unlink($f->path);
            }
            $f->delete();
        }

        if ($preventionPlan->delete()) {
            $this->res['result'] = 'success';
            $this->res['state'] = true;
        }else {
            $this->res['error'] = '削除に失敗しました．';
        }
        return $response->withJson($this->res);
    }

    /* Get a count of saved plan for each year or month. */
    public function getLatestPreventionPlan(Request $request, Response $response, $args) {
        $params = $request->getAttribute('params');

        $query = new PreventionPlanSearch(PreventionPlan::query(), $params->get);
        $latestDisasters = $query->getLatestCount();

        return $response->withJson($latestDisasters);
    }

    private function uploadFiles($params, $preventionPlan){
        $upload = Upload::getInstance();
        $upload->init($params->path);
        $files = [];
        $array = (array)$params->post;
        for($i = 0; $i < intval($params->post->fileCounts); $i++){
            if($upload->move($array["file_".$i."_id"], 'plans/' . $array["file_".$i."_name"])){
                $f = new File();
                $f->fill([
                    'name' => $array["file_".$i."_name"],
                    'type' => $upload->getType($array["file_".$i."_name"]),
                    'path' => $upload->getUploadPath() . 'plans/' . $array["file_".$i."_name"],
                    'thumbnail_path' => ''
                ]);
                $files[] = $f;
            };
        }
        $preventionPlan->uploads()->saveMany($files);
    }
}