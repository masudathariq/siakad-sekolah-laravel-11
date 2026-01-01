@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center space-x-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 rounded-lg bg-slate-200 text-slate-400 cursor-not-allowed text-[10px] uppercase font-bold">Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition text-[10px] uppercase font-bold">Prev</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1 rounded-lg bg-slate-200 text-slate-400 text-[10px] uppercase font-bold">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 rounded-lg bg-blue-600 text-white text-[10px] uppercase font-bold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition text-[10px] uppercase font-bold">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition text-[10px] uppercase font-bold">Next</a>
        @else
            <span class="px-3 py-1 rounded-lg bg-slate-200 text-slate-400 cursor-not-allowed text-[10px] uppercase font-bold">Next</span>
        @endif
    </nav>
@endif
