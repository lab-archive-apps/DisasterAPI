<?php

namespace App\Controller\API;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;
use App\Models\Storage\Disaster;
use App\Models\Storage\ResponseRecord;
use App\Search\ResponseRecordSearch;
use App\Uploads\Upload;
use App\Models\File;

class ResponseRecordsController extends BaseController{
    /* Get responseRecords */
    public function getResponseRecords(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $disaster = Disaster::find($params->get->disaster_id);

        $query = new ResponseRecordSearch($disaster->records(), $params->get);
        $disaster['records'] = $query->search();

        return $response->withJson($disaster);
    }

    /* Get responseRecord with corresponds */
    public function getResponseRecord(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        $responseRecord = ResponseRecord::findOrFail($params->get->record_id);
        $responseRecord['disaster'] = $responseRecord->disaster;
        $preventionPlan['uploads'] = $responseRecord->uploads;
        return $response->withJson($responseRecord);
    }

    /* Post responseRecord */
    public function postResponseRecord(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $disaster = Disaster::findOrFail($params->post->disaster_id);

        $responseRecord = new ResponseRecord();
        $responseRecord->fill([
            'division' => $params->post->division,
            'section' => $params->post->section,
            'status' => $params->post->status,
            'comments' => $params->post->comments,
        ]);

        if ($disaster->records()->save($responseRecord)) {
            $this->uploadFiles($params, $responseRecord);
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
        $responseRecord = ResponseRecord::find($params->post->record_id);
        $data = [
            'division' => $params->post->division,
            'section' => $params->post->section,
            'status' => $params->post->status,
            'comments' => $params->post->comments,
        ];

        if ($responseRecord->update($data)){
            $this->uploadFiles($params, $responseRecord);
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
        $responseRecord = ResponseRecord::findOrFail($params->post->record_id);

        foreach ($responseRecord->uploads as $fKey => $f) {
            if (file_exists($f->path)) {
                unlink($f->path);
            }
            $f->delete();
        }

        if ($responseRecord->delete()) {
            $this->res['result'] = 'success';
            $this->res['state'] = true;
        }else {
            $this->res['error'] = '削除に失敗しました．';
        }
        return $response->withJson($this->res);
    }

    private function uploadFiles($params, $responseRecord){
        $upload = Upload::getInstance();
        $upload->init($params->path);
        $files = [];
        $array = (array)$params->post;
        for($i = 0; $i < intval($params->post->fileCounts); $i++){
            if($upload->move($array["file_".$i."_id"], 'records/' . $array["file_".$i."_name"])){
                $f = new File();
                $f->fill([
                    'name' => $array["file_".$i."_name"],
                    'type' => $upload->getType($array["file_".$i."_name"]),
                    'path' => $upload->getUploadPath() . 'records/' . $array["file_".$i."_name"],
                    'thumbnail_path' => ''
                ]);
                $files[] = $f;
            };
        }
        $responseRecord->uploads()->saveMany($files);
    }
}