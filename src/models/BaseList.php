<?php
namespace App\Models;

class BaseList extends BaseModel {
    protected $table = 'todo_lists'; // Set a Table Name

    public function messages(){
        return $this->hasMany(TodoList::class, 'list_id');
    }
}