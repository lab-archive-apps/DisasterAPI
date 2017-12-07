<?php
namespace App\Models\Setting;

use App\Models\BaseModel;

/**
 * Scale Database Model
 * @package App\Models
 */
class Section extends BaseModel {
    protected $table = 'sections'; // Set a Table Name

    // enable params when called create method.
    protected $fillable = [
        'name',
        'label'
    ];
}