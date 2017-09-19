<?php
namespace App\Models;

/**
 * Base Plan Database Model
 * Class BasePlan
 * @package App\Models
 */
class BasePlan extends BaseModel {
    protected $table = 'prevention_plans'; // Set a Table Name

    public function details(){
        return $this->hasMany(PreventionPlan::class, 'plan_id');
    }

    // enable params when called create method.
    protected $fillable = [
        'name',
    ];
}