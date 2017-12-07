<?php
namespace App\Models\Setting;

use App\Models\BaseModel;

/**
 * Status Database Model
 * @package App\Models
 */
class Status extends BaseModel {
    protected $table = 'status'; // Set a Table Name

    // enable params when called create method.
    protected $fillable = [
        'name',
    ];
}