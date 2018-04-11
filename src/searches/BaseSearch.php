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

    // Get latest items from query.
    protected function getLatestItem($query = null) {
        $__count = [];

        if($query === null) return [];

        // Exist `year` and `month` in params
        if(isset($this->params->year) && isset($this->params->month)) {
            $query
                ->whereYear('created_at', '=', $this->params->year)
                ->whereMonth('created_at', '=', $this->params->month)
                ->orderBy('created_at', $this->order);

            $days = cal_days_in_month(CAL_GREGORIAN, $this->params->month, $this->params->year);
            for ($i = 1; $i <= $days; $i++){
                $__query = clone $query;
                $__count[] = $__query->whereDay('created_at', '=', $i)->get()->count();
            }

            return [
                'count' => $__count,
                'items' => $query->get()
            ];
        }

        // Exist `year` in params
        if(isset($this->params->year)) {
            $query
                ->whereYear('created_at', '=', $this->params->year)
                ->orderBy('created_at', $this->order);

            for ($i = 1; $i <= 12; $i++){
                $__query = clone $query;
                $__count[] = $__query->whereMonth('created_at', '=', $i)->get()->count();
            }

            return [
                'count' => $__count,
                'items' => $query->get()
            ];
        }

        return [];
    }
}