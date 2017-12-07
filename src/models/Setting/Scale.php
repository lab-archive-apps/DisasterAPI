<?php
namespace App\Models\Setting;

use App\Models\BaseModel;

/**
 * Scale Database Model
 * @package App\Models
 */
class Scale extends BaseModel {
    protected $table = 'scales'; // Set a Table Name

    // enable params when called create method.
    protected $fillable = [
        'name',
    ];
}