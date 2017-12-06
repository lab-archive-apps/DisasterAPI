<?php
namespace App\Models\Region;

use App\Models\BaseModel;

/**
 * City Database Model
 * Class Disaster Correspond Content
 * @package App\Models
 */
class City extends BaseModel {
    protected $table = 'cities'; // Set a Table Name

    public function prefecture(){
        return $this->belongsTo('App\Models\Region\Prefecture');
    }

    // enable params when called create method.
    protected $fillable = [
        'id',
        'prefecture_id',
        'name',
        'name_kana',
        'name_en',
        'code',
        'path'
    ];
}