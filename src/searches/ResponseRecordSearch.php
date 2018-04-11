<?php

namespace App\Search;

/* Disaster Response Record search logic */
class ResponseRecordSearch extends BaseSearch {
    public function search() {
        return $this->query
            ->orderBy('created_at', $this->order)
            ->get(['id', 'division', 'section', 'status']);
    }

    public function getLatestCount() {
        return $this->getLatestItem($this->query);
    }
}