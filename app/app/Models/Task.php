<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'project_id',
        'status'
    ];

    protected function casts(): array
    {
        return [
            'status'=>TaskStatus::class
        ];
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function assignedUser()
    {
        return $this->belongsTo(User::class,'assigned_to');
    }
}
