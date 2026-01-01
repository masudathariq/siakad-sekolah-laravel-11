<div class="bg-white shadow-md rounded-xl p-6">
    <h4 class="text-md font-semibold text-gray-700 mb-4">{{ $nama }}</h4>
    <p class="text-sm text-gray-500 mb-2">Total Siswa: <span class="font-bold">{{ $total }}</span></p>
    <div class="w-full bg-gray-200 h-4 rounded-full overflow-hidden mb-2">
        <div class="bg-blue-600 h-4" style="width: {{ $persenLaki }}%"></div>
        <div class="bg-pink-500 h-4 -ml-{{ $persenLaki }}" style="width: {{ $persenPerempuan }}%"></div>
    </div>
    <div class="flex justify-between text-xs font-medium text-gray-600">
        <span>Laki-laki: {{ $laki }}</span>
        <span>Perempuan: {{ $perempuan }}</span>
    </div>
</div>
