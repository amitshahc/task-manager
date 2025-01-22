@extends('tasks::layouts.master')

@section('content')
    @include('tasks::message')

    @include('tasks::projects')

    <ul id="dragList" class="drag-list">
        @forelse ($tasks as $task)
            <li class="drag-item" draggable="true">
                <h2>{{ $task->title }}</h2>
                <p>{{ $task->description }}</p>
            </li>
        @empty
            {{ __('No task found.') }}
        @endforelse
        {{-- <li class="drag-item" draggable="true">
            <h2>Mobile</h2>
            <p>
                Descrption
            </p>
        </li>
        <li class="drag-item" draggable="true">Laptop</li>
        <li class="drag-item" draggable="true">Desktop</li>
        <li class="drag-item" draggable="true">Television</li>
        <li class="drag-item" draggable="true">Radio</li> --}}
    </ul>

    <form method="GET" action="{{ route('tasks.create') }}"
        onsubmit="this.project_id_current.value = document.getElementById('projects_menu').value">
        <input type="hidden" name="project_id_current" value="{{ $project_id_current }}" />
        <div class="relative h-32 w-32">
            <div class="absolute bottom-0 right-0 h-16 w-16">
                <x-primary-button class="ms-4 flex-right" type="submit">
                    {{ __('Add New Task') }}
                </x-primary-button>
            </div>
        </div>
    </form>

    <style>
        .drag-list {
            list-style: none;
            padding: 0;
        }

        .drag-item>h2 {
            background-color: rgba(86, 103, 255, 0.81);
            padding: 10px;
            margin-bottom: 5px;
            cursor: move;
        }
    </style>
@endsection
