<?php

namespace App\Controller;

use App\Auth\Session;

abstract class BaseController {
    protected $container = null;    // Container of Slim Framework
    protected $view = null;         // view Object(twig)
    protected $session = null;      // Session
    protected $router = null;       // router
    protected $flash = null;        // Flash Messages

    function __invoke($req, $res, $args){}

    final public function __construct($container){
        $this->container = $container;
        $this->view = $container['view'];
        $this->session = Session::getInstance();
        $this->router = $container['router'];
        $this->flash = $container['flash'];
    }
}