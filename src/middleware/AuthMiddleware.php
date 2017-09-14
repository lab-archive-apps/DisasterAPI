<?php

namespace App\Middleware;

use App\Auth\Session;
use App\Config\SingletonCore;

// Set up Authorization
final class AuthMiddleware extends SingletonCore{

    private $session;   // Session
    private $view;      // view Object(twig)
    private $router;    // router
    private $flash;     // Flash Messages

    public function __invoke($request, $response, $next)
    {
        // before process //

        // Redirect if not login.
        if(!$this->session->state()){
            $this->flash->addMessage('errors', 'ログインしてください');
            return $response->withRedirect('/');
        }

        $response = $next($request, $response);

        // after process //

        return $response;
    }

    public function init($container){
        $this->session = Session::getInstance();
        $this->view = $container['view'];
        $this->router = $container['router'];
        $this->flash = $container['flash'];
    }
}