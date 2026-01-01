{{-- GRID MENU UTAMA --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

    {{-- DATA SISWA --}}
    <a href="{{ route('admin.siswa.index') }}"
       class="bg-white p-5 rounded-xl border hover:shadow-lg transition group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Manajemen</p>
                <h3 class="text-lg font-semibold text-gray-800">Data Siswa</h3>
            </div>
            <div class="text-3xl group-hover:scale-110 transition">👨‍🎓</div>
        </div>
    </a>

    {{-- DATA GURU --}}
    <a href="{{ route('admin.guru.index') }}"
       class="bg-white p-5 rounded-xl border hover:shadow-lg transition group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Manajemen</p>
                <h3 class="text-lg font-semibold text-gray-800">Data Guru</h3>
            </div>
            <div class="text-3xl group-hover:scale-110 transition">👨‍🏫</div>
        </div>
    </a>

    {{-- ROMBEL --}}
    <a href="{{ route('admin.tahun-ajaran.index') }}"
       class="bg-white p-5 rounded-xl border hover:shadow-lg transition group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Akademik</p>
                <h3 class="text-lg font-semibold text-gray-800">Rombel</h3>
            </div>
            <div class="text-3xl group-hover:scale-110 transition">🏫</div>
        </div>
    </a>

    {{-- ABSENSI --}}
    <a href="{{ route('admin.absen.index') }}"
       class="bg-white p-5 rounded-xl border hover:shadow-lg transition group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Kehadiran</p>
                <h3 class="text-lg font-semibold text-gray-800">Absensi</h3>
            </div>
            <div class="text-3xl group-hover:scale-110 transition">⏱</div>
        </div>
    </a>

</div>

{{-- SURAT --}}
<div class="mt-8">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Manajemen Surat</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

        {{-- SURAT MASUK --}}
        <a href="{{ route('admin.surat-masuk.index') }}"
           class="bg-white p-6 rounded-xl border hover:shadow-lg transition group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Administrasi</p>
                    <h3 class="text-lg font-semibold text-gray-800">Surat Masuk</h3>
                </div>
                <div class="text-4xl group-hover:scale-110 transition">📥</div>
            </div>
        </a>

        {{-- SURAT KELUAR --}}
        <a href="#" {{-- pastikan route dibuat di web.php --}}
           class="bg-white p-6 rounded-xl border hover:shadow-lg transition group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Administrasi</p>
                    <h3 class="text-lg font-semibold text-gray-800">Surat Keluar</h3>
                </div>
                <div class="text-4xl group-hover:scale-110 transition">📤</div>
            </div>
        </a>

    </div>
</div>