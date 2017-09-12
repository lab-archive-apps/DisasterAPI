<?php

namespace App\Middleware;

use App\Auth\Session;
use App\Config\SingletonCore;

// セッション認証管理
final class AuthMiddleware extends SingletonCore{

    private $session;   // Session
    private $view;      // view Object(twig)
    private $router;    // router
    private $flash;     // Flash Messages

    public function __invoke($request, $response, $next)
    {
        // ここに前処理 //

        // ログインしていなかったらリダイレクト
        if(!$this->session->state()){
            $this->flash->addMessage('errors', 'ログインしてください');
            return $response->withRedirect('/');
        }

        $response = $next($request, $response);

        // ここには後処理 //

        return $response;
    }

    public function init($container){
        $this->session = Session::getInstance();
        $this->view = $container['view'];
        $this->router = $container['router'];
        $this->flash = $container['flash'];
    }
}