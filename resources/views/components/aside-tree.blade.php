@props(['title', 'icon', 'routePrefix'])

<div x-data="{ open: currentPath.startsWith('{{ $routePrefix }}') }">
    <button @click="open = !open"
        :class="currentPath.startsWith('{{ $routePrefix }}') ? 'bg-zinc-700' : ''"
        class="flex items-center w-full px-6 py-3 hover:bg-zinc-700 transition">
        <i class="{{ $icon }} mr-2"></i> {{ $title }}
        <i class="fa-solid fa-chevron-down ml-auto" :class="{ 'rotate-180': open }"></i>
    </button>
    <div x-show="open" class="pl-8 space-y-1">
        {{ $slot }}
    </div>
</div>
