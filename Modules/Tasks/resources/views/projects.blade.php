<div class="pb-3">
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        {{-- @method('POST') --}}
        <input type="hidden" name="project_id_current" value="{{ $project_id_current }}" />

        <x-select-dropdown id="projects_menu" name="projects_menu" label="Project">
            {{-- @isset($projects) --}}
            @forelse ($projects as $project)
                <option value="{{ $project->id }}" {{$project_id_current == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
            @empty
                <option value="0">{{ Config::get('tasks.projects.default_name') }}</option>
            @endforelse
            {{-- @endisset --}}
        </x-select-dropdown>

        <x-text-input name="new_project" required />
        <x-secondary-button class="ms-4 right-0" type="submit">
            {{ __('Add New Project') }}
        </x-secondary-button>
    </form>

    @push('local_scripts')
        <script>
            document.getElementById('projects_menu').addEventListener('change', function() {
                console.log(this.options[this.selectedIndex].value);
                window.location.href = "{{ route('tasks.index') }}?project_id_current=" + this.value;
            });
        </script>
    @endpush

</div>
