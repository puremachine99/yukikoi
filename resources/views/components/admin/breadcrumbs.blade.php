<div class="w-full bg-blue-950 pt-4 pb-4 px-8 flex items-center">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            @foreach($breadcrumbs as $breadcrumb)
                <li class="inline-flex items-center">
                    @if(!$loop->last)
                        <a href="{{ $breadcrumb['url'] }}" class="text-sm font-medium text-white hover:underline">
                            {{ $breadcrumb['label'] }}
                        </a>
                        <svg class="w-4 h-4 mx-2 text-indigo-200" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7.05 4.05a.75.75 0 011.06 0l4.25 4.25a.75.75 0 010 1.06l-4.25 4.25a.75.75 0 11-1.06-1.06L10.19 10 7.05 6.86a.75.75 0 010-1.06z"/>
                        </svg>
                    @else
                        <span class="text-sm font-semibold text-indigo-200">{{ $breadcrumb['label'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
</div>