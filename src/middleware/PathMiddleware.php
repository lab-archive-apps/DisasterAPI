<?php

namespace App\Middleware;

use App\Auth\Session;
use App\Config\SingletonCore;

// Set up Request Parameter
final class PathMiddleware extends SingletonCore{

    private $setting = null;    // settings

    public function __invoke($req, $res, $next)
    {
        // before process //
        $params = [];
        $params['get'] = $req->getQueryParams();                // $_GET
        $params['post'] = $req->getParsedBody();                // $_POST
        $params['files'] = $req->getUploadedFiles();            // $_FILES
        $params['session'] = Session::getInstance()->getAll();  // $_SESSION
        $params['path'] = $this->setting['renderer'];        // Path

        // Change Array to Object
        $req = $req->withAttribute('params', json_decode(json_encode($params)));

        $response = $next($req, $res);

        // after process //

        return $response;
    }

    public function init($container){
        $this->setting = $container['settings'];
    }
}