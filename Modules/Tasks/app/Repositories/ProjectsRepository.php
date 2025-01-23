<?php

namespace Modules\Tasks\Repositories;

use App\Models\Projects;
use App\Models\User;
use Illuminate\Support\Facades\Config;

class ProjectsRepository
{
    public function __construct() {}

    public function createDefaultUserProject(User $user)
    {
        $user->projects()->firstOrCreate(['name' => Config::get('tasks.projects.default_name')]);
    }

    public function getUserProjectList(User $user)
    {
        return $user->projects;
    }

    public function createUserProject(User $user, $project_name)
    {
        $user->projects()->create([
            "name" => $project_name
        ]);

        return;
    }

    public function getUserProject(User $user, $project_id)
    {
        return $user->project($project_id);
    }

    public function getDefaultProject(User $user, $project_id = null)
    {
        if (is_null($project_id)) {
            return $user->projects()->first();
        } else {
            return $user->projects()->whereId($project_id);
        }
    }
}
