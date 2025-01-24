@extends('tasks::layouts.master')

@section('content')
    <div class="mb-4">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </div>


    @include('tasks::message')

    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PATCH')
        <input type="hidden" name="project_id_current" value="{{ $project->id }}" />

        <x-input-label>
            {{ __('Project') }} : {{ $project->name }}
        </x-input-label>

        <div class="mt-4">
            <x-input-label>
                {{ __('Title') }}
            </x-input-label>
            <x-text-input name="title" maxlength=100 value="{{ old('title', $task->title) }}" />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label>
                {{ __('Descrption') }}
            </x-input-label>
            <x-textarea-input name="description" class="w-full block" maxlength=255>
                {{ old('description', $task->description) }}
            </x-textarea-input>
            <small class="block">maximum length 255</small>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="mt-4 text-left">
            <a href="{{ route('tasks.index', ['project_id_current' => $project->id]) }}">
                <x-secondary-button type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>
            </a>
            <x-primary-button type="submit">
                {{ __('Save') }}
            </x-primary-button>
        </div>
    @endsection
