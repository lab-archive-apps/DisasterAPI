<?php

namespace App\Search;

/* Prevention Plan search logic */
class PreventionPlanSearch extends BaseSearch {
    public function search() {
        return $this->query
            ->orderBy('created_at', $this->order)
            ->get(['id', 'name', 'classification']);
    }
}