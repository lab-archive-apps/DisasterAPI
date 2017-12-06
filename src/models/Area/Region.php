<?php
namespace App\Models\Area;

use App\Models\BaseModel;
/**
 * Region Database Model
 * Class Disaster Correspond Content
 * @package App\Models
 */
class Region extends BaseModel {
    protected $table = 'regions'; // Set a Table Name

    public function prefectures() {
        return $this->hasMany('App\Models\Area\Prefecture');
    }

    // enable params when called create method.
    protected $fillable = [
        'id',
        'name',
        'name_kana',
        'name_en',
    ];
}