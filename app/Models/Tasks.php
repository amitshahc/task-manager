<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tasks\Database\Factories\TaskFactory;

class Tasks extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description', 'is_completed', 'priority', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Projects::class);
    }

    public function user()
    {
        return $this->project->user();
    }

    protected static function newFactory()
    {
        return TaskFactory::new();
    }
}
