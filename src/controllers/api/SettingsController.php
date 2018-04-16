<?php

namespace App\Controller\API;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;

use App\Models\Setting\Classification;
use App\Models\Setting\Scale;
use App\Models\Setting\Section;
use App\Models\Setting\Status;
use App\Models\Setting\Division;

/* Setting Management Controller */
class SettingsController extends BaseController {
    /* Get classifications */
    public function getClassifications(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        return $response->withJson($this->index(Classification::query()));
    }

    /* Get scales */
    public function getScales(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        return $response->withJson($this->index(Scale::query()));
    }

    /* Get sections */
    public function getSections(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        return $response->withJson($this->index(Section::query()));
    }

    /* Get status */
    public function getStatus(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        return $response->withJson($this->index(Status::query()));
    }

    /* Get divisions */
    public function getDivisions(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        return $response->withJson($this->index(Division::query()));
    }

    /* Post classification */
    public function postClassification(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $classification = new Classification();
        $this->create($classification, [
            'name' => $params->post->name
        ]);
        return $response->withJson($this->res);
    }

    /* Post scale */
    public function postScale(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $scale = new Scale();
        $this->create($scale, [
            'name' => $params->post->name
        ]);
        return $response->withJson($this->res);
    }

    /* Post section */
    public function postSection(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $section = new Section();
        $this->create($section, [
            'name' => $params->post->name
        ]);
        return $response->withJson($this->res);
    }

    /* Post status */
    public function postStatus(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $status = new Status();
        $this->create($status, [
            'name' => $params->post->name
        ]);
        return $response->withJson($this->res);
    }

    /* Post division */
    public function postDivision(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $division = new Division();
        $this->create($division, [
            'name' => $params->post->name
        ]);
        return $response->withJson($this->res);
    }

    /* Update classification */
    public function updateClassification(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $classification = Classification::find($params->post->id);
        $this->update($classification, [
            'name' => $params->post->name,
        ]);
        return $response->withJson($this->res);
    }

    /* Update scale */
    public function updateScale(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $scale = Scale::find($params->post->id);
        $this->update($scale, [
            'name' => $params->post->name
        ]);
        return $response->withJson($this->res);
    }

    /* Update section */
    public function updateSection(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $section = Section::find($params->post->id);
        $this->update($section, [
            'name' => $params->post->name
        ]);
        return $response->withJson($this->res);
    }

    /* Update status */
    public function updateStatus(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $status = Status::find($params->post->id);
        $this->update($status, [
            'name' => $params->post->name
        ]);
        return $response->withJson($this->res);
    }

    /* Update division */
    public function updateDivision(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $division = Division::find($params->post->id);
        $this->update($division, [
            'name' => $params->post->name
        ]);
        return $response->withJson($this->res);
    }

    /* Delete classification */
    public function deleteClassification(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $classification = Classification::find($params->post->id);
        $this->delete($classification);
        return $response->withJson($this->res);
    }

    /* Delete scale */
    public function deleteScale(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $scale = Scale::find($params->post->id);
        $this->delete($scale);
        return $response->withJson($this->res);
    }

    /* Delete section */
    public function deleteSection(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $section = Section::find($params->post->id);
        $this->delete($section);
        return $response->withJson($this->res);
    }

    /* Delete status */
    public function deleteStatus(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $status = Status::find($params->post->id);
        $this->delete($status);
        return $response->withJson($this->res);
    }

    /* Delete division */
    public function deleteDivision(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $division = Division::find($params->post->id);
        $this->delete($division);
        return $response->withJson($this->res);
    }

    /* index function */
    private function index($query){
        return $query->orderBy('created_at', 'desc')->get();
    }

    /* create function */
    private function create($model, $params){
        $model->fill($params);

        if ($model->save()) {
            $this->res['result'] = 'success';
            $this->res['state'] = true;
            $this->res['item'] = $model;
        }else{
            $this->res['error'] = '登録に失敗しました．';
        }
    }

    /* update function */
    private function update($model, $data){
        if ($model->update($data)){
            $this->res['result'] = 'success';
            $this->res['state'] = true;
        }else {
            $this->res['error'] = '更新に失敗しました．';
        }
    }

    /* delete function */
    private function delete($model){
        if ($model->delete()) {
            $this->res['result'] = 'success';
            $this->res['state'] = true;
        }else {
            $this->res['error'] = '削除に失敗しました．';
        }
    }
}