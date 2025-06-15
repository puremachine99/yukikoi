@props(['href', 'icon'])

<a href="{{ $href }}" 
   :class="currentPath === '{{ $href }}' ? 'bg-gray-700' : ''"
   class="block px-6 py-3 hover:bg-gray-700 transition flex items-center">
    <i class="{{ $icon }} mr-2"></i> {{ $slot }}
</a>
