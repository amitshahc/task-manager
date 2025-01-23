<?php

namespace Modules\Tasks\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\Tasks\Repositories\ProjectsRepository;
use Throwable;

class ProjectsController extends Controller
{
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
        return redirect()->route('tasks.index')->with('success', __('Project created successfully.'));
    }
}
