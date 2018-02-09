<?php
namespace App\Models\Setting;

use App\Models\BaseModel;

/**
 * Division Database Model
 * @package App\Models
 */
class Division extends BaseModel {
    protected $table = 'divisions'; // Set a Table Name

    // enable params when called create method.
    protected $fillable = [
        'name',
    ];
}