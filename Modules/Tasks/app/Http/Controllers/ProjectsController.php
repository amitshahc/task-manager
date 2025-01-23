<?php

namespace Modules\Tasks\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\Tasks\Repositories\ProjectsRepository;
use Throwable;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tasks::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ProjectsRepository $repo, TasksController $tasks)
    {
        try {
            $validated = $request->validate([
                'new_project' => [
                    'required',
                    Rule::unique('projects', 'name')->where(fn(Builder $query) => $query->where('user_id', Auth::id()))
                ]
            ]);

            $repo->createUserProject(Auth::user(), $request->get('new_project'));
        } catch (Throwable $th) {
            return redirect()->route('tasks.index')->with('error', $th->getMessage());
        }
        return redirect()->route('tasks.index')->with('success', 'Project created successfully.');

        // response()->redirectToRoute('tasks.index');
        // $projects = $repo->getUserProjectList(Auth::user());
        // return view('tasks::index', ['projects' => $projects]);
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
}
