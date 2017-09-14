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
use App\Models\PreventionPlan;
use App\Models\BaseList;
use App\Search\DisasterSearch;

class JsonController extends BaseController {

    /* Get disaster with corresponds */
    public function getDisaster(Request $request, Response $response, $args){
        $disasters = Disaster::query()->with(['corresponds'])->get()->toJson();
        return $disasters;
    }

    /* Get disasters name, season, class */
    public function getDisasters(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        $query = new DisasterSearch(Disaster::query(), $params->get);
        $disasters = $query->search();

        return $disasters;
    }

    /* Get prevention plan */
    public function getPlan(Request $request, Response $response, $args){
        $plans = PreventionPlan::query()->get()->toJson();
        return $plans;
    }

    /* Get plans name. */
    public function getPlans(Request $request, Response $response, $args){
        $plans = PreventionPlan::query()->get()->toJson();
        return $plans;
    }

    /* Get list with messages. */
    public function getList(Request $request, Response $response, $args){
        $lists = BaseList::with(['messages'])->get()->toJson();
        return $lists;
    }

    /* Get lists name */
    public function getLists(Request $request, Response $response, $args){
        $lists = BaseList::query()->get()->toJson();
        return $lists;
    }
}