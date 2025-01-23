<?php

namespace Modules\Tasks\Repositories;

use App\Models\Tasks;
use App\Models\User;

class TasksRepository
{
    public function __construct() {}

    public function createTask(User $user, $task)
    {
        $proejct_id = $task['project_id'];
        $highestPriority = $user->tasks()->where('project_id', $proejct_id)->max('priority');
        $task['priority'] = ++$highestPriority ?? 0;
        $user->tasks()->create($task);
    }

    public function getProjectTasks(User $user, $proejct_id)
    {
        return $user->tasks()->whereProjectId($proejct_id)->orderBy('priority')->get();
    }

    public function reorderProjectTasks(User $user, $proejct_id, $ordered_ids)
    {
        $priority_cnt = 0;
        foreach ($ordered_ids as $id) {
            $user->tasks()
                ->where('project_id', $proejct_id)
                ->where('tasks.id', $id)
                ->update(['priority' => $priority_cnt++]);
        }
    }

    public function getTask($id)
    {
        $task = Tasks::find($id);
        return $task;
    }

    public function updateTask($id, $data)
    {
        return Tasks::findOrFail($id)->update($data);
    }

    public function deleteTask($id)
    {
        return Tasks::destroy($id);
    }
}
