<?php
namespace App\Models;

/**
 * ResponseRecord Database Model
 * Class ResponseRecord
 * @package App\Models
 */
class ResponseRecord extends BaseModel {
    protected $table = 'response_records'; // Set a Table Name

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