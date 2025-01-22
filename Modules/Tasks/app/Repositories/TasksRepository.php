<?php

namespace Modules\Tasks\Repositories;

use App\Models\Projects;
use App\Models\User;
use Illuminate\Support\Facades\Config;

class TasksRepository
{
    public function __construct() {}

    public function createTask(User $user, $task)
    {
        $user->tasks()->create($task);
    }

    public function getProjectTasks(User $user, $proejct_id)
    {
        return $user->tasks()->whereProjectId($proejct_id)->get();
    }
}
