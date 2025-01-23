<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class Tasks extends Model
{
    protected $guarded = [];

    protected $fillable = ['title', 'description', 'is_completed', 'priority', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
