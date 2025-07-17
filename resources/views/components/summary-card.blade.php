<!-- resources/views/components/summary-card.blade.php -->
@props([
    'icon' => 'chart-bar',
    'title' => '',
    'value' => '',
    'color' => 'bg-blue-100 text-blue-800',
])

<div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6">
    <div class="flex items-center">
        <div class="p-3 rounded-full {{ $color }}">
            <x-icon :name="$icon" class="w-6 h-6" />
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                {{ $title }}
            </p>
            <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                {{ $value }}
            </p>
        </div>
    </div>
</div>