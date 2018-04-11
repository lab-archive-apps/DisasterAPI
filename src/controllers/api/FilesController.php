<?php
namespace App\Controller\API;

use App\Models\File;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;
use App\Uploads\Upload;

/**
 * Control the file upload function.
 * Class FilesController
 * @package App\Controller\API
 */
class FilesController extends BaseController{
    /* Upload */
//    public function postFile(Request $request, Response $response, $args){
//        $params = $request->getAttribute('params');
//        $uploadPath = $params->path->public_path . 'uploads';
//        // Check upload directory if exist.
//        if (!file_exists($uploadPath)) {
//            mkdir(public_path($uploadPath), 0777, true);
//        }
//
//        return $response->withJson($this->res);
//    }

    /* Temp Upload */
    public function postTempFile(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        if(!isset($_FILES)){
            $this->res['error'] = 'File not found.';
            return $response->withJson($this->res);
        }

        // Upload Logic.
        for($i = 0; $i < count($_FILES); $i++){
            if($_FILES["file-$i"]['tmp_name']) {
                // Change State.
                $this->res['result'] = 'success';
                $this->res['state'] = true;
                // Upload Function
                $upload = Upload::getInstance();
                $upload->init($params->path);
                $result = $upload->tempUpload($_FILES["file-$i"]);
                if ($result['state']) {
                    $this->res['files'][$i]['result'] = 'success';
                    $this->res['files'][$i]['state'] = true;
                    $this->res['files'][$i]['id'] = $result['id'];
                    $this->res['files'][$i]['error'] = 'Upload Success.';
                } else {
                    $this->res['files'][$i]['error'] = 'Upload Failed.';
                    $this->res['files'][$i]['id'] = null;
                }
            } else {
                $this->res['files'][$i]['error'] = 'Not exist file in params．';
            }
            $this->res['files'][$i]['name'] = $_FILES["file-$i"]['name'];
            $this->res['files'][$i]['type'] = $_FILES["file-$i"]['type'];
        }
        return $response->withJson($this->res);
    }

    /* Delete File */
    public function deleteFile(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $file = File::find($params->post->id);
        if (file_exists($file->path)) {
            if(unlink($file->path)){
                $file->delete();
                $this->res['result'] = 'success';
                $this->res['state'] = true;
            } else{
                $this->res['error'] = '削除に失敗しました．';
            }
        }

        return $response->withJson($this->res);
    }

    /* Delete Temp File */
    public function deleteTempFile(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $tempPath = $params->path->public_path . 'temp';
        if (file_exists($tempPath . '/' . $params->post->id)) {
            if(unlink($tempPath . '/' . $params->post->id)){
                $this->res['result'] = 'success';
                $this->res['state'] = true;
            }else{
                $this->res['error'] = '削除に失敗しました．';
            }
        }
        return $response->withJson($this->res);
    }

    // get file type from inputted argument
    private function getType($f){
        $divides = explode('.', $f['name']);
        return end($divides);
    }
}