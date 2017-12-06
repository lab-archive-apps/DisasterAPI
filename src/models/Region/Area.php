<?php
namespace App\Models\Region;

use App\Models\BaseModel;
/**
 * Region Database Model
 * Class Disaster Correspond Content
 * @package App\Models
 */
class Area extends BaseModel {
    protected $table = 'areas'; // Set a Table Name

    public function prefectures() {
        return $this->hasMany('App\Models\Region\Prefecture');
    }

    // enable params when called create method.
    protected $fillable = [
        'id',
        'name',
        'name_kana',
        'name_en',
    ];
}