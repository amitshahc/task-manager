<?php

namespace Modules\Tasks\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Tasks\Repositories\ProjectsRepository;
use Modules\Tasks\Repositories\TasksRepository;
use Throwable;


class TasksController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ProjectsRepository $repoProjects, TasksRepository $repoTasks)
    {
        $projects = $repoProjects->getUserProjectList(Auth::user());

        $project_id_current = $request->has('project_id_current') ?  $request->get('project_id_current') : $projects->first()->id;

        $tasks = $repoTasks->getProjectTasks(Auth::user(), $project_id_current);

        return view('tasks::task-list', ['projects' => $projects, 'tasks' => $tasks, 'project_id_current' => $project_id_current]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, ProjectsRepository $repoProjects)
    {
        $project = $repoProjects->getUserProject(Auth::user(), $request->get('project_id_current'));
        return view('tasks::task-create', ['project' => $project]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, TasksRepository $repo)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'max:100',
                Rule::unique('tasks', 'title')->where(fn(Builder $query) => $query->where('project_id', $request->get('project_id_current')))
            ],
            'description' => ['required', 'max:255'],
            'project_id_current' => [
                'required',
                Rule::exists('projects', 'id')->where(fn(Builder $query) => $query->where('user_id', Auth::id()))
            ]
        ]);

        $validated['project_id'] = $validated['project_id_current'];

        try {
            $repo->createTask(Auth::user(), $validated);
        } catch (Throwable $th) {
            return redirect()->route('tasks.create', ['project_id_current' => $request->get('project_id_current')])->with('error', $th->getMessage());
        }

        return redirect()->route('tasks.index', ['project_id_current' => $request->get('project_id_current')])->with('success',  __('Task created successfully.'));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('tasks::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, TasksRepository $repo)
    {
        try {
            $task = $repo->getTask($id);
            $this->authorize('view', $task);
            $project = $task->project;
        } catch (Throwable $th) {
            return redirect()->route('tasks.index')->with('error', $th->getMessage());
        }

        return view('tasks::task-edit', compact('task', 'project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, TasksRepository $repo)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'max:100',
                Rule::unique('tasks', 'title')->ignore($id)->where(fn(Builder $query) => $query->where('project_id', $request->get('project_id_current')))
            ],
            'description' => ['required', 'max:255'],
            'project_id_current' => [
                'required',
                Rule::exists('projects', 'id')->where(fn(Builder $query) => $query->where('user_id', Auth::id()))
            ]
        ]);

        $validated['project_id'] = $validated['project_id_current'];

        try {
            $repo->updateTask($id, $validated);
        } catch (Throwable $th) {
            return redirect()->route('tasks.index')->with('error', $th->getMessage());
        }

        return redirect()->route('tasks.index', ['project_id_current' => $request->get('project_id_current')])->with('success',  __('Task updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, TasksRepository $repo)
    {
        try {
            $task = $repo->getTask($id);
            $this->authorize('delete', $task);
            $project = $task->project;
            $repo->deleteTask($id);
        } catch (Throwable $th) {
            return redirect()->route('tasks.index')->with('error', $th->getMessage());
        }

        return redirect()->route('tasks.index', ['project_id_current' => $project->id])->with('success',  __('Task deleted successfully.'));
    }

    public function reorder(Request $request, TasksRepository $repo)
    {
        try {
            $Validator = Validator::make($request->all(), [
                'project_id_current' => [
                    'required',
                    Rule::exists('projects', 'id')->where(fn(Builder $query) => $query->where('user_id', Auth::id()))
                ],
                'new_order' => [
                    'required',
                    'json'
                ]
            ]);

            if ($Validator->fails()) {
                return redirect()->route('tasks.index', ['project_id_current' => $request->get('project_id_current')])->withErrors($Validator->errors());
            }

            $project_id = $request->get('project_id_current');
            $ordered_ids = json_decode($request->get('new_order'), true);

            $repo->reorderProjectTasks(Auth::user(), $project_id, $ordered_ids);
        } catch (Throwable $th) {
            return redirect()->route('tasks.index', ['project_id_current' => $request->get('project_id_current')])->with('error', $th->getMessage());
        }
        return redirect()->route('tasks.index', ['project_id_current' => $request->get('project_id_current')])->with('success', 'Task order saved successfully.');
    }
}
