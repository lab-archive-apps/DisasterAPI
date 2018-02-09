<?php

namespace App\Controller;

use App\Auth\Session;

abstract class BaseController {
    protected $container = null;    // Container of Slim Framework
    protected $session = null;      // Session
    protected $router = null;       // router
    protected $res = [
        'result' => 'failed',
        'state' => false,
        'error' => ''
    ];

    function __invoke($req, $res, $args){}

    final public function __construct($container){
        $this->container = $container;
        $this->session = Session::getInstance();
        $this->router = $container['router'];
    }
}