<?php
namespace App\Models;

/**
 * Disaster Database Model
 * Class Disaster
 * @package App\Models
 */
class Disaster extends BaseModel{
    protected $table = 'disasters'; // Set a Table Name

    public function corresponds(){
        return $this->hasMany('App\Models\DisasterCorrespond', 'disaster_id');
    }

    public function coordinates(){
        return $this->hasMany('App\Models\DisasterCoordinate', 'disaster_id');
    }

    // enable params when called create method.
    protected $fillable = [
        'name',
        'date',
        'season',
        'area',
        'prefecture',
        'city',
        'classification',
        'scale',
        'latitude',
        'longitude',
    ];
}