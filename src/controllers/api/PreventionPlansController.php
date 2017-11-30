<?php

namespace App\Controller\API;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;
use App\Search\PreventionPlanSearch;
use App\Models\PreventionPlan;

class PreventionPlansController extends BaseController{
    private $res = [
        'result' => 'failed',
        'state' => false,
        'error' => ''
    ];

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

        // TODO: not use find(), because if $preventionPlans returned "[]", slim3 would call "500 error".
        $preventionPlans = PreventionPlan::query()
            ->where('id', $params->get->plan_id)
            ->first();
        return $response->withJson($preventionPlans);
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
        $data = [];

        if ($preventionPlan->update($data)){
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

        if ($preventionPlan->delete()) {
            $this->res['result'] = 'success';
            $this->res['state'] = true;
        }else {
            $this->res['error'] = '削除に失敗しました．';
        }
        return $response->withJson($this->res);
    }
}