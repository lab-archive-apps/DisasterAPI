<?php

namespace App\Middleware;

use App\Auth\Session;
use App\Config\SingletonCore;

// 各種パス設定
final class PathMiddleware extends SingletonCore{

    private $setting = null;    // settings

    public function __invoke($req, $res, $next)
    {
        // ここに前処理 //
        $params = [];
        $params['get'] = $req->getQueryParams();                // $_GET の中身
        $params['post'] = $req->getParsedBody();                // $_POST の中身
        $params['files'] = $req->getUploadedFiles();             // $_FILES の中身
        $params['session'] = Session::getInstance()->getAll();  // $_SESSION の中身
        // $params['path'] = $this->setting['renderer'];        // Path

        // 連想配列をオブジェクトに変換
        $req = $req->withAttribute('params', json_decode(json_encode($params)));

        $response = $next($req, $res);

        // ここには後処理 //

        return $response;
    }

    public function init($container){
        $this->setting = $container['settings'];
    }
}