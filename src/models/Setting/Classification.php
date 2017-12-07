<?php
namespace App\Models\Setting;

use App\Models\BaseModel;

/**
 * Classification Database Model
 * @package App\Models
 */
class Classification extends BaseModel {
    protected $table = 'classifications'; // Set a Table Name

    // enable params when called create method.
    protected $fillable = [
        'name',
    ];
}