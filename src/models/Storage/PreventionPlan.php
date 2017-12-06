<?php
namespace App\Models\Storage;

use App\Models\BaseModel;
/**
 * PreventionPlan Database Model
 * Class Disaster
 * @package App\Models
 */
class PreventionPlan extends BaseModel{
    protected $table = 'prevention_plans'; // Set a Table Name

    public function uploads(){
        return $this->morphMany('App\Models\File', 'resource');
    }

    // enable params when called create method.
    protected $fillable = [
        'name',
        'location',
        'classification',
    ];
}