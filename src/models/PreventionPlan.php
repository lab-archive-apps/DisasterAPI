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

    // create メソッド使用時に許可するカラム
    protected $fillable = [
        'plan_id',
        'title',
        'phase',
        's_date',
        'e_date',
        'content',
    ];
}