@extends('tasks::layouts.master')

@section('content')
    <div class="mb-4">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Task List') }}
        </h2>
    </div>
    @include('tasks::message')

    @include('tasks::projects')

    {{ $tasks->withQueryString()->links() }}
    
    <x-select-dropdown id="tasks_per_page" name="per_page" label="Per page">
        <option value="2" {{ session()->get('per_page') == "2" ? 'selected' : ''}}>2</option>
        <option value="5" {{ session()->get('per_page') == "5" ? 'selected' : ''}}>5</option>
        <option value="10" {{ session()->get('per_page') == "10" ? 'selected' : ''}}>10</option>
        <option value="25" {{ session()->get('per_page') == "25" ? 'selected' : ''}}>25</option>
    </x-select-dropdown>
    <br />

    <ul id="dragList" class="drag-list flex flex-col">
        @forelse ($tasks as $task)
            <li class="drag-item" draggable="true" data-id="{{ $task->id }}">
                <div class="bg-gray-500 rounded-lg shadow-md p-6 mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-white-500">{{ $task->title }}</h3>
                            <p class="text-gray-300 text-sm mt-1">{!! nl2br($task->description) !!}</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('tasks.edit', ['task' => $task, 'page' => $tasks->currentPage()]) }}"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <x-secondary-button>
                                    Edit
                                </x-secondary-button>
                            </a>
                            <form action="{{ route('tasks.destroy', ['task' => $task, 'page' => $tasks->currentPage()]) }}"
                                method="POST" onsubmit="return confirm('Are you sure, You want to delete the recored?')">
                                @csrf
                                @method('DELETE')
                                <x-red-button type="submit">
                                    Delete
                                </x-red-button>
                            </form>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            {{ __('No task found.') }}
        @endforelse
    </ul>

    <div class="mx-4  flex justify-between items-center">

        <div class="inline-flex">
            @if (!$tasks->isEmpty())
                <form method="POST" action="{{ route('tasks.reorder', ['page' => $tasks->currentPage()]) }}"
                    onsubmit="return updateOrder(this)" id="frmReorder">
                    @csrf
                    <input type="hidden" name="old_order" />
                    <input type="hidden" name="new_order" />
                    <input type="hidden" name="project_id_current" value="{{ $project_id_current }}" />
                    <x-secondary-button type="submit">
                        Save Order
                    </x-secondary-button>
                </form>
            @endif
        </div>

        <div class="inline-flex">
            <form method="GET" action="{{ route('tasks.create') }}"
                onsubmit="this.project_id_current.value = document.getElementById('projects_menu').value">
                <input type="hidden" name="project_id_current" value="{{ $project_id_current }}" />
                <div class="relative h-32 w-32">
                    <div class="bottom-0 right-0">
                        <x-primary-button class="ms-4 flex-right" type="submit">
                            {{ __('Add New Task') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('local_scripts')
        <script src="{{ Module::asset('tasks:js/dragable.js') }}"></script>
        <link href="{{ Module::asset('tasks:css/dragable.css') }}" rel="stylesheet">

        <script>
            document.getElementById('tasks_per_page').addEventListener('change', function() {

                let perPage = document.getElementById('tasks_per_page').value;
                let params = new URLSearchParams(window.location.search);

                params.set('per_page', perPage);

                window.location.href = window.location.pathname + '?' + params.toString();
            });
        </script>
    @endpush
@endsection
