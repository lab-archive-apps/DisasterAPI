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
                ->withHeader('Access-Control-Allow-Origin', 'http://localhost:3000')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    public function init($container){
        $this->setting = $container['settings'];
    }
}