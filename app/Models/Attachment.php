<?php

namespace App\Models;

use App\Constants\DatabaseTables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $table = DatabaseTables::ATTACHMENTS->value;

    protected $fillable = [
        'task_id',
        'path',
        'name',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
