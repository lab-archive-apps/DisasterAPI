<?php
namespace App\Models;

/**
 * Disaster Coordinate Database Model
 * Class DisasterCoordinate
 * @package App\Models
 */
class DisasterCoordinate extends BaseModel {
    protected $table = 'disaster_coordinates'; // Set a Table Name

    public function disaster(){
        return $this->belongsTo('App\Models\Disaster');
    }

    // create メソッド使用時に許可するカラム
    protected $fillable = [
        'disaster_id',
        'label',
        'type',
        'latitude',
        'longitude',
    ];
}