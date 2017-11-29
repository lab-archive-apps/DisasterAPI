<?php

namespace App\Search;

/* Disaster Response Record search logic */
class ResponseRecordSearch extends BaseSearch {
    public function search() {
        return $this->query
            ->orderBy('created_at', 'desc')
            ->get(['id', 'name']);
    }
}