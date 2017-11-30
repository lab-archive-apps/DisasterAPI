<?php
namespace App\Controller\API;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;


class FilesController extends BaseController{
    private $res = [
        'result' => 'failed',
        'state' => false,
        'error' => ''
    ];

    /* Upload */
    public function postFile(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $uploadPath = $params->path->public_path . 'uploads';
        // Check upload directory if exist.
        if (!file_exists($uploadPath)) {
            mkdir(public_path($uploadPath), 0777, true);
        }

        return $response->withJson($this->res);
    }

    /* Temp Upload */
    public function postTempFile(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $tempPath = $params->path->public_path . 'temp';
        // Check Temp directory if exist.
        if (!file_exists($tempPath)) {
            mkdir(public_path($tempPath), 0777, true);
        }

        // Upload Logic.
//        if($_FILES['file']['tmp_name']){
//            $name = 'temp_' . date('YmdHis') . '_' . $_FILES['file']['name'];
//            if(move_uploaded_file($_FILES['file']['tmp_name'], $tempPath . '/' . $name)){
//                chmod($tempPath . '/' . $name, 0755);
//                $this->res['result'] = 'success';
//                $this->res['state'] = true;
//                $this->res['id'] = $name;
//                $this->res['error'] = 'Upload Success.';
//            }else {
//                $this->res['error'] = 'Upload Failed.';
//                $this->res['id'] = null;
//            }
//        }else {
//            $this->res['error'] = 'Not exist file in params．';
//        }
        foreach($_FILES['file']['type'] as $key => $f){
            $this->res[$key] = $f;
        }

        return $response->withJson($this->res);
    }

    /* Delete File */
    public function deleteFile(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $tempPath = $params->path->public_path . 'temp';
        if(unlink($tempPath . '/' . $params->post->id)){
            $this->res['result'] = 'success';
            $this->res['state'] = true;
        }else{
            $this->res['error'] = '削除に失敗しました．';
        }
        $this->res['p'] = $params->post;

        return $response->withJson($this->res);
    }

    // get file type from inputted argument
    private function getType($f){
        $divides = explode('.', $f['name']);
        return end($divides);
    }
}