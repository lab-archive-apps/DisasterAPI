<?php

namespace App\Search;

/* Disaster search logic */
class DisasterSearch extends BaseSearch {
    public function search() {
        return $this->query
            ->orderBy('created_at', $this->order)
            ->get(['id', 'name', 'date', 'classification']);
    }

    public function getLatestCount() {
        return $this->getLatestItem($this->query);
    }
}