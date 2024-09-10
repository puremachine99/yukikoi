@props(['options', 'name', 'id', 'value' => ''])

<div>
    <label for="{{ $id }}" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $slot }}</label>
    <select id="{{ $id }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'block w-full mt-1 p-2 bg-white border border-zinc-300 dark:bg-zinc-800 dark:border-zinc-600 dark:text-zinc-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:border-indigo-300 focus:ring-indigo-200 dark:focus:ring-indigo-700']) }}>
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}>{{ $optionLabel }}</option>
        @endforeach
    </select>
</div>
