<?php
namespace App\Models;

/**
 * Prevention Plan Database Model
 * Class PreventionPlan
 * @package App\Models
 */
class PreventionPlan extends BaseModel {
    protected $table = 'prevention_plans_details'; // Set a Table Name

    public function base(){
        return $this->belongsTo(BasePlan::class);
    }

    // enable params when called create method.
    protected $fillable = [
        'plan_id',
        'title',
        'phase',
        's_date',
        'e_date',
        'content',
    ];
}