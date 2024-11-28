@props(['disabled' => false])

<input 
    type="number" 
    step="any" 
    inputmode="decimal" 
    {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge(['class' => 'border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}>
