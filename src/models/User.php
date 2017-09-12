<?php
namespace App\Models;

/**
 * User Database Model
 * Class User
 * @package App\Models
 */
class User extends BaseModel {
    protected $table = 'users'; // Set a Table Name

    // create メソッド使用時に許可するカラム
    protected $fillable = [
        'user_id',
        'password',
        'admin',
    ];
}