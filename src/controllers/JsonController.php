<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Disaster;
//use App\Models\PreventionPlan;
use App\Models\BaseList;
use App\Search\DisasterSearch;
use App\Models\DisasterContent as Content;

class JsonController extends BaseController {

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

    /* Get disasters name, season, class */
    public function getDisasters(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        $query = new DisasterSearch(Disaster::query(), $params->get);
        $disasters = $query->search();

        return $disasters;
    }

    /* Get disaster correspond sections. */
    public function getSections(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $sections = Content::query()
            ->where('type', 'section')
            ->get(['id', 'name'])->toJson();
        return $sections;
    }

    /* Get prevention plan */
//    public function getPlan(Request $request, Response $response, $args){
//        $params = $request->getAttribute('params');
//
//        $plans = PreventionPlan::query()->get()->toJson();
//        return $plans;
//    }
//
//    /* Get plans name. */
//    public function getPlans(Request $request, Response $response, $args){
//        $params = $request->getAttribute('params');
//
//        $plans = PreventionPlan::query()->get()->toJson();
//        return $plans;
//    }

    /* Get list with messages. */
    public function getList(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        $lists = BaseList::with(['messages'])->get()->toJson();
        return $lists;
    }

    /* Get lists name */
    public function getLists(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        $lists = BaseList::query()->get()->toJson();
        return $lists;
    }
}