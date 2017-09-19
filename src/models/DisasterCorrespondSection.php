<?php
namespace App\Models;

/**
 * Disaster Correspond Section Database Model
 * Class Disaster Correspond Section
 * @package App\Models
 */
class DisasterCorrespondSection extends BaseModel {
    protected $table = 'disaster_correspond_sections'; // Set a Table Name

    // enable params when called create method.
    protected $fillable = [
        'id',
        'name',
    ];
}