<?php
namespace App\Uploads;

use App\Config\SingletonCore;

class Upload extends SingletonCore {
    private $publicPath = '';
    private $tempPath = '';
    private $uploadPath = '';
    private $result = [
        'state' => false,
        'id' => ''
    ];

    public function __construct(){}

    public function init($path) {
        $this->publicPath = $path->public_path;
        $this->tempPath = $path->public_path . 'temp';
        $this->uploadPath = $path->public_path . 'uploads';

        // Check directory if exist.
        if (!file_exists($this->tempPath)) {
            mkdir(public_path($this->tempPath), 0777, true);
        }

        if (!file_exists($this->uploadPath)) {
            mkdir(public_path($this->uploadPath), 0777, true);
        }

        if (!file_exists($this->uploadPath . '/plans')) {
            mkdir(public_path($this->uploadPath. '/plans'), 0777, true);
        }

        if (!file_exists($this->uploadPath . '/records')) {
            mkdir(public_path($this->uploadPath. '/records'), 0777, true);
        }
    }

    public function getPublicPath(){
        return $this->publicPath;
    }

    public function getTempPath(){
        return $this->tempPath . '/';
    }

    public function getUploadPath(){
        return $this->uploadPath . '/';
    }

    // Move File
    public function move($from, $to) {
        return rename($this->tempPath . '/' . $from, $this->uploadPath . '/' . $to);
    }

    // Temp file upload.
    public function tempUpload($file){
        $name = 'temp_' . date('YmdHis') . '_' . basename($file['name']);
        if(move_uploaded_file($file['tmp_name'], $this->tempPath . '/' . $name)) {
            chmod($this->tempPath . '/' . $name, 0777);
            $this->result['state'] = true;
        }
        $this->result['id'] = $name;
        return $this->result;
    }

    public function getType($file_name){
        $splits = explode('.', $file_name);
        return $splits[count($splits)-1];
    }
}