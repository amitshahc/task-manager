@props(['label' => 'Select', 'id' => 'select_id'])


<label for="{{$id}}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</label>
<select id="{{$id}}" class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
    {{$slot}}    
</select>
