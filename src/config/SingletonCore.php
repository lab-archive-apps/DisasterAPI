<?php

namespace App\Config;

use Exception;

/**
 * Singleton Design Pattern of PHP
 */
abstract class SingletonCore{
    //コンストラクタはprotected
    protected function __construct(){}

    final public static function getInstance()
    {
        static $instance;
        return $instance ?: $instance = new static;
    }

    final public function __clone()
    {
        throw new Exception("this instance is singleton class.");
    }
}