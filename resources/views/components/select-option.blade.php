@props(['options', 'name', 'id', 'value' => ''])

<div>
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $slot }}</label>
    <select id="{{ $id }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'block w-full mt-1 p-2 bg-white border border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:border-indigo-300 focus:ring-indigo-200 dark:focus:ring-indigo-700']) }}>
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}>{{ $optionLabel }}</option>
        @endforeach
    </select>
</div>
