{{-- JUMLAH SEMUA SISWA --}}
<div class="mt-12">

    <div class="relative bg-gradient-to-br from-indigo-50 to-white
                border border-indigo-100 rounded-2xl p-8
                shadow-sm hover:shadow-md transition">

        <!-- Accent -->
        <div class="absolute inset-x-0 top-0 h-1 rounded-t-2xl
                    bg-gradient-to-r from-indigo-500 to-pink-400"></div>

        <!-- Header -->
        <p class="text-sm font-semibold text-slate-600 tracking-wide text-center mb-2 mt-2">
            Total Seluruh Siswa
        </p>

        <!-- Angka Utama -->
        <p class="text-5xl font-extrabold text-slate-800 text-center mb-6">
            {{ $regulerTotal + $pondokTotal }}
        </p>

        <!-- Breakdown -->
        <div class="grid grid-cols-2 gap-6 text-center">

            <!-- Laki-laki -->
            <div class="bg-white rounded-xl border p-4">
                <p class="text-xs text-slate-500 mb-1">
                    Laki-laki
                </p>
                <p class="text-2xl font-bold text-indigo-700">
                    {{ $regulerLaki + $pondokLaki }}
                </p>
            </div>

            <!-- Perempuan -->
            <div class="bg-white rounded-xl border p-4">
                <p class="text-xs text-slate-500 mb-1">
                    Perempuan
                </p>
                <p class="text-2xl font-bold text-pink-700">
                    {{ $regulerPerempuan + $pondokPerempuan }}
                </p>
            </div>

        </div>
    </div>
</div>