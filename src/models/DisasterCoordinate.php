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

    // enable params when called create method.
    protected $fillable = [
        'disaster_id',
        'label',
        'type',
        'latitude',
        'longitude',
    ];
}