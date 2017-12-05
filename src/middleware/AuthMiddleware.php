<?php

namespace App\Middleware;

use App\Auth\Session;
use App\Config\SingletonCore;

// Set up Authorization
final class AuthMiddleware extends SingletonCore{

    private $session;   // Session
    private $router;    // router

    public function __invoke($request, $response, $next)
    {
        // before process //

        $response = $next($request, $response);

        // after process //

        return $response;
    }

    public function init($container){
        $this->session = Session::getInstance();
        $this->router = $container['router'];
    }
}