<div class="bg-white shadow-md rounded-xl p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">{{ $title }}</h3>
    <div class="grid grid-cols-3 gap-4 text-center">
        <div>
            <p class="text-sm font-medium text-gray-500">Total</p>
            <p class="text-xl font-bold text-{{ $color }}-600">{{ $total }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Laki-laki</p>
            <p class="text-xl font-bold text-{{ $color }}-600">{{ $laki }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Perempuan</p>
            <p class="text-xl font-bold text-{{ $color }}-600">{{ $perempuan }}</p>
        </div>
    </div>
</div>
