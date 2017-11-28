<?php

namespace App\Search;

/* Disaster search logic */
class DisasterSearch extends BaseSearch {
    public function search() {
        return $this->query
            ->orderBy('created_at', 'desc')
            ->get(['id', 'name', 'date']);
    }
}