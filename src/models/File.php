<?php
namespace App\Models;

/**
 * File Database Model
 * Class Disaster
 * @package App\Models
 */
class File extends BaseModel{
    protected $table = 'files'; // Set a Table Name

    public function resource(){
        return $this->morphTo();
    }

    // enable params when called create method.
    protected $fillable = [
        'resource_id',
        'resource_type',
        'name',
        'type',
        'path',
        'thumbnail_path'
    ];
}