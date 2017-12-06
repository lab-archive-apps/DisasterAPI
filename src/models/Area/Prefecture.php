<?php
namespace App\Models\Area;

use App\Models\BaseModel;
/**
 * Prefecture Database Model
 * Class Disaster Correspond Content
 * @package App\Models
 */
class Prefecture extends BaseModel {
    protected $table = 'prefectures'; // Set a Table Name

    public function region(){
        return $this->belongsTo('App\Models\Area\Region');
    }

    public function cities(){
        return $this->hasMany('App\Models\Area\City');
    }

    // enable params when called create method.
    protected $fillable = [
        'id',
        'region_id',
        'name',
        'name_kana',
        'name_en',
        'code',
    ];
}