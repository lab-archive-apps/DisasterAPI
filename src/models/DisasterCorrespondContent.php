<?php
namespace App\Models;

/**
 * Disaster Correspond Content Database Model
 * Class Disaster Correspond Content
 * @package App\Models
 */
class DisasterCorrespondContent extends BaseModel {
    protected $table = 'disaster_correspond_contents'; // Set a Table Name

    // enable params when called create method.
    protected $fillable = [
        'id',
        'name',
    ];
}