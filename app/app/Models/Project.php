<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
        'owner_id'
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => ProjectStatus::class
        ];
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function owner()
    {
        return $this->belongsTo(User::class,'owner_id');
    }
}
