<?php

namespace App\Middleware;

use App\Config\SingletonCore;

// Set up Cross Origin Resource Sharing
final class CorsMiddleware extends SingletonCore{

    private $setting = null;    // settings

    public function __invoke($req, $res, $next)
    {
        // before process //

        $response = $next($req, $res);

        // after process //

        return $response
                // TODO: CookieをAjaxで使う時には '*' は使えないので注意!
                ->withHeader('Access-Control-Allow-Origin', '*')
//                ->withHeader('Access-Control-Allow-Origin', 'http://localhost:3000')
//                ->withHeader('Access-Control-Allow-Origin', 'http://localhost:9000')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                // TODO: CookieをAjaxで使う時専用
//            ->withHeader('Access-Control-Allow-Credentials', 'true')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, HEAD, OPTIONS');
    }

    public function init($container){
        $this->setting = $container['settings'];
    }
}