<?php

namespace Modules\Tasks\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Tasks\Repositories\ProjectsRepository;
use Modules\Tasks\Repositories\TasksRepository;
use Throwable;

class TasksController extends Controller
{
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

        return redirect()->route('tasks.index')->with('success',  __('Task created successfully.'));
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
    public function edit($id)
    {
        return view('tasks::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function reorder(Request $request)
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
        } catch (Throwable $th) {
            return redirect()->route('tasks.index', ['project_id_current' => $request->get('project_id_current')])->with('error', $th->getMessage());
        }
        return redirect()->route('tasks.index', ['project_id_current' => $request->get('project_id_current')])->with('success', 'Task order saved successfully.');
    }
}
