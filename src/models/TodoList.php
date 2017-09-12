<?php
namespace App\Models;

/**
 * List Database Model
 * Class TodoList
 * @package App\Models
 */
class TodoList extends BaseModel {
    protected $table = 'todo_lists_messages'; // Set a Table Name

    public function base() {
        return $this->belongsTo(BaseList::class);
    }

    // create メソッド使用時に許可するカラム
    protected $fillable = [
        'list_id',
        'message',
    ];
}