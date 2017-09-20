<?php
namespace App\Models;

/**
 * Disaster Content Database Model
 * Class Disaster Correspond Content
 * @package App\Models
 */
class DisasterContent extends BaseModel {
    protected $table = 'disaster_contents'; // Set a Table Name

    // enable params when called create method.
    protected $fillable = [
        'id',
        'name',
        'type'
    ];
}