@if (session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 relative">
        <p class="font-bold">Error!</p>
        <p>{{ session('error') }}</p>
        <button type="button" class="absolute top-2 right-2 text-green-700 hover:text-green-900"
            style="top: 1px; right: 1px;" onclick="this.parentNode.remove()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
@endif

@if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 relative">
        <p class="font-bold">Success!</p>
        <p>{{ session('success') }}</p>
        <button type="button" class="absolute top-2 right-2 text-green-700 hover:text-green-900"
            style="top: 1px; right: 1px;" onclick="this.parentNode.remove()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
@endif
