<?php

namespace App\Search;

/* User search logic */
class UserSearch extends BaseSearch {
    public function search() {
        return $this->query
            ->orderBy('created_at', 'desc')
            ->get(['id', 'name']);
    }
}