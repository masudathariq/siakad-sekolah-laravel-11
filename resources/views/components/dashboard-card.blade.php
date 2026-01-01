<a href="{{ $route }}" class="group bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
    <div class="flex items-center justify-between mb-4">
        <div class="p-3 bg-{{ $color }}-100 rounded-lg text-{{ $color }}-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="{{ $svg }}" />
            </svg>
        </div>
        <span class="text-2xl">{{ $icon }}</span>
    </div>
    <div>
        <p class="text-xs font-semibold uppercase text-gray-500 mb-1">{{ $subtitle }}</p>
        <h3 class="text-lg font-bold text-gray-900">{{ $title }}</h3>
    </div>
</a>
