@props([
    'icon',
    'title',
    'active' => false,
    'routes' => [],
])

<li x-data="{ open: {{ $active ? 'true' : 'false' }} }">
    <button @click="open = !open"
        class="flex items-center w-full gap-3 px-4 py-2 rounded-lg transition duration-150 focus:outline-none
        {{ $active ? 'bg-white text-gray-700 font-semibold shadow-sm' : 'hover:shadow-md hover:bg-white hover:text-indigo-500' }}">
        <i class="{{ $icon }} w-5 h-5"></i> {{ $title }}
        <svg :class="{ 'rotate-90': open }" class="ml-auto h-4 w-4 transition-transform" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>
    <ul x-show="open" class="pl-8 py-1 space-y-1" x-cloak>
        @foreach($routes as $route)
            <li>
                <a href="{{ $route['href'] ?? '#' }}"
                    class="flex items-center gap-2 px-3 py-1.5 rounded-md text-sm
                    {{ $route['active'] ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'hover:text-indigo-500' }}">
                    {{ $route['label'] }}
                </a>
            </li>
        @endforeach
    </ul>
</li>