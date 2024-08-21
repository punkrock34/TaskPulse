<?php

namespace App\Models;

use App\Constants\DatabaseTables;
use App\Constants\TaskPriority;
use App\Constants\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = DatabaseTables::TASKS->value;

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'description',
        'user_id',  // Ensure user_id is fillable
        'deadline',
        'priority',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'status' => TaskStatus::class,
            'priority' => TaskPriority::class,
            'deadline' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'task_id');
    }
}
