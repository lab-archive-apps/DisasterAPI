<?php
namespace App\Models;

/**
 * PreventionPlan Database Model
 * Class Disaster
 * @package App\Models
 */
class PreventionPlan extends BaseModel{
    protected $table = 'prevention_plans'; // Set a Table Name

    public function uploads(){
        return $this->hasMany('App\Models\File');
    }
    // enable params when called create method.
    protected $fillable = [
        'location',
        'classification',
    ];
}