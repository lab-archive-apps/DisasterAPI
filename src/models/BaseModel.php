<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Config\DBManager;

/**
 * Base Model
 * Class BaseModel
 * @package App\Models
 */
class BaseModel extends Model{
    public function __construct(array $attributes = array()){
        // Connect to database
        DBManager::getInstance()->init();

        parent::__construct($attributes);
    }
}