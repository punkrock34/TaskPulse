<?php

namespace App\Models;

use App\Constants\DatabaseTables;
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
    ];

    protected function casts(): array
    {
        return [
            'status' => TaskStatus::class,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
