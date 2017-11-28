<?php

namespace App\Controller\API;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;
use App\Models\Disaster;
use App\Search\ResponseRecordSearch;

class ResponseRecordsController extends BaseController{
    private $res = [
        'result' => 'failed',
        'state' => false,
        'error' => ''
    ];


    /* Get responseRecords */
    public function getResponseRecords(Request $request, Response $response, $args)
    {
        $params = $request->getAttribute('params');

        $query = new ResponseRecordSearch(ResponseRecord::query(), $params->get);
        $responseRecords = $query->search();

        return $response->withJson($responseRecords);
    }

    /* Get responseRecord with corresponds */
    public function getResponseRecord(Request $request, Response $response, $args)
    {
        $params = $request->getAttribute('params');

        // TODO: not use find(), because if $responseRecords returned "[]", slim3 would call "500 error".
        $responseRecords = ResponseRecord::query()
            ->where('id', $params->get->responseRecord_id)
            //->with(['corresponds', 'coordinates'])
            ->first();
        return $response->withJson($responseRecords);
    }

    /* Post responseRecord */
    public function postResponseRecord(Request $request, Response $response, $args)
    {
        $params = $request->getAttribute('params');

        $responseRecord = new ResponseRecord();
        // $responseRecord->fill([]);

        if ($responseRecord->save()) {
            $this->res['result'] = 'success';
            $this->res['state'] = true;
        }else{
            $this->res['error'] = '登録に失敗しました．';
        }

        return $response->withJson($this->res);
    }

    /* Update responseRecord */
    public function updateResponseRecord(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $responseRecord = ResponseRecord::find($params->post->responseRecord_id);
        $data = [];

        if ($responseRecord->update($data)){
            $this->res['result'] = 'success';
            $this->res['state'] = true;
        }else {
            $this->res['error'] = '更新に失敗しました．';
        }

        return $response->withJson($this->res);
    }

    /* Delete responseRecord */
    public function deleteResponseRecord(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $responseRecord = ResponseRecord::find($params->post->responseRecord_id);

        if ($responseRecord->delete()) {
            $this->res['result'] = 'success';
            $this->res['state'] = true;
        }else {
            $this->res['error'] = '削除に失敗しました．';
        }
        return $response->withJson($this->res);
    }
}