<?php
namespace App\Models;

/**
 * Disaster Correspond Database Model
 * Class DisasterCorrespond
 * @package App\Models
 */
class DisasterCorrespond extends BaseModel {
    protected $table = 'disaster_corresponds'; // Set a Table Name

    public function disaster(){
        return $this->belongsTo('App\Models\Disaster');
    }

    public function uploads(){
        return $this->hasMany('App\Models\File');
    }

    // enable params when called create method.
    protected $fillable = [
        'disaster_id',
        'name',
        'section',
        'contents',
        'comments',
    ];
}