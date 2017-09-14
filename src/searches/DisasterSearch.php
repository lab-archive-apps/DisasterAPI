<?php

namespace App\Search;

/* Disaster search logic */
class DisasterSearch extends BaseSearch
{

    public function search() {
        // true if "not empty parameter", "not empty string", "not 0 length"
        if (!empty($this->params)
            && isset($this->params->word)
            && strlen($this->params->word) > 0) {
            return $this->query
                ->where('name', 'LIKE', "%{$this->params->word}%")
                ->orWhere('season', 'LIKE', "%{$this->params->word}%")
                ->orWhere('class', 'LIKE', "%{$this->params->word}%")
                ->orderBy('created_at', 'desc')
                ->get(['id', 'name'])
                ->toJson();
        }else {
            return json_encode((object) null);
        }

    }
}