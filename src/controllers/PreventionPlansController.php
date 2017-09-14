<?php

namespace App\Controller;

use App\Models\BasePlan;
use App\Models\PreventionPlan;
use Illuminate\Support\Facades\DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/* Prevention PreventionPlan Management Controller */
class PreventionPlansController extends BaseController {

    public function index(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $plans = BasePlan::query()->get();

        return $this->view->render($response, '/plans/index.twig', [
            'params' => $params,
            'plans' => $plans
        ]);
    }

    public function create(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        return $this->view->render($response, '/plans/create.twig', [
            'params' => $params,
        ]);
    }

    public function show(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        return $this->view->render($response, '/plans/show.twig', [
            'params' => $params,
        ]);
    }

    public function edit(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        return $this->view->render($response, '/plans/edit.twig', [
            'params' => $params,
        ]);
    }

    public function store(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $plan = new BasePlan(['name' => $params->post->name]);

        if($plan->save()){
            $details = [];
            foreach ($params->post->plan as $key => $value){
                $d = new PreventionPlan();
                $d->fill(json_decode(json_encode($value), true));
                $details[] = $d;
            }
            $plan->details()->saveMany($details);
            $this->flash->addMessage('notice', '登録が完了しました．');
            return $response->withRedirect($this->router->pathFor('plan_index', [], []));
        }else{
            $this->flash->addMessage('error', '登録に失敗しました．');
            return $response->withRedirect($this->router->pathFor('plan_create', [], [
                'params' => $params,
            ]));
        }
    }

    public function update(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
    }

    public function delete(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
    }
}