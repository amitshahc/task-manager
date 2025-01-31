<?php

namespace Modules\Tasks\Repositories;

use App\Models\Tasks;
use App\Models\User;

class TasksRepository
{
    public function __construct() {}

    public function createTask(User $user, $task)
    {
        $project_id = $task['project_id'];
        $highestPriority = $user->tasks()->where('project_id', $project_id)->max('priority');
        $task['priority'] = ++$highestPriority ?? 0;
        $user->tasks()->create($task);
    }

    public function getProjectTasks(User $user, $project_id, $per_page = null)
    {
        if ($per_page) {
            return $user->tasks()->whereProjectId($project_id)->orderBy('priority')->paginate($per_page);
        } else {
            return $user->tasks()->whereProjectId($project_id)->orderBy('priority')->get();
        }
    }

    public function reorderProjectTasks(User $user, $project_id, $old_ordered_ids, $new_ordered_ids)
    {
        //Get current page tasks list with old order
        $tasks = $user->tasks()
            ->where('project_id', $project_id)
            ->whereIn('tasks.id', $old_ordered_ids)
            ->orderBy('priority')->get();

        // Get the associated priority from old order
        $priority = $tasks->pluck('priority')->toArray();

        // assign the same priority in order but fetch the ids order by new-order-id list
        foreach ($new_ordered_ids as $id) {
            $user->tasks()
                ->where('project_id', $project_id)
                ->where('tasks.id', $id)
                ->update(['priority' => array_shift($priority)]);
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
