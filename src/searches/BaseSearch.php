<?php

namespace App\Search;

/* Base search logic */
abstract class BaseSearch {

    protected $query;
    protected $params;
    protected $order = 'desc';

    abstract public function search();

    public function __construct($query, $params = null) {
        $this->query = $query;
        $this->params = $params;
    }

}