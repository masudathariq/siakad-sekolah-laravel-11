@extends('layouts.admin')

@section('title', 'Tambah Data Guru')

@section('content')
<div class="py-8 px-4 sm:px-6">
    <div class="max-w-4xl mx-auto">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl font-black text-slate-800">Tambah Data Guru</h1>
                <p class="text-xs text-slate-400 uppercase tracking-widest">
                    Registrasi Tenaga Pendidik
                </p>
            </div>
            <a href="{{ route('admin.guru.index') }}"
               class="px-4 py-2 border rounded-lg text-xs font-bold text-slate-500">
                Kembali
            </a>
        </div>

        {{-- CARD --}}
        <div class="bg-white rounded-2xl shadow border overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-indigo-600 to-violet-600"></div>

            <form action="{{ route('admin.guru.store') }}" method="POST" class="p-6 md:p-8 space-y-10">
                @csrf

                @php
                    $input = 'w-full px-4 py-2.5 border rounded-xl text-xs font-semibold focus:ring-2 focus:ring-indigo-500';
                @endphp

                {{-- ================= DATA UTAMA ================= --}}
                <section>
                    <h4 class="section-title">Profil & Identitas</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="label">ID Guru *</label>
                            <input name="id_guru" required class="{{ $input }}">
                        </div>

                        <div>
                            <label class="label">Nama Lengkap *</label>
                            <input name="nama" required class="{{ $input }}">
                        </div>

                        <div>
                            <label class="label">Jenis Kelamin *</label>
                            <select name="jenis_kelamin" required class="{{ $input }}">
                                <option value="">Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="label">Status Kepegawaian *</label>
                            <select name="status_kepegawaian" required class="{{ $input }}">
                                <option value="">Pilih</option>
                                <option value="GTY">GTY</option>
                                <option value="GTTY">GTTY</option>
                            </select>
                        </div>

                        <div>
                            <label class="label">Tempat Lahir</label>
                            <input name="tempat_lahir" class="{{ $input }}">
                        </div>

                        <div>
                            <label class="label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="{{ $input }}">
                        </div>

                        <div>
                            <label class="label">NBM</label>
                            <input name="nbm" class="{{ $input }}">
                        </div>

                        <div>
                            <label class="label">NUPTK</label>
                            <input name="nuptk" class="{{ $input }}">
                        </div>

                        <div>
                            <label class="label">Pendidikan *</label>
                            <select name="pendidikan" required class="{{ $input }}">
                                @foreach(['SMA','D I','D II','D III','D IV','S1','S2','S3'] as $p)
                                    <option value="{{ $p }}">{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="label">Jurusan</label>
                            <input name="jurusan" class="{{ $input }}">
                        </div>

                        <div>
                            <label class="label">Status Sertifikasi *</label>
                            <select name="status_sertifikasi" required class="{{ $input }}">
                                <option value="belum">Belum</option>
                                <option value="sertifikasi">Sertifikasi</option>
                                <option value="ppg">PPG</option>
                            </select>
                        </div>

                        <div>
                            <label class="label">TMT *</label>
                            <input type="date" name="tmt" required class="{{ $input }}">
                        </div>
                    </div>
                </section>

                {{-- ================= JABATAN ================= --}}
{{-- ================= JABATAN ================= --}}
<section>
    <h4 class="section-title">Jabatan</h4>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
        @foreach([
            'kepala_madrasah' => 'Kepala Madrasah',
            'wakil_kepala' => 'Wakil Kepala',
            'kepala_tu' => 'Kepala TU',
            'staff_tu' => 'Staff TU',
            'bendahara' => 'Bendahara',
            'guru_mapel' => 'Guru Mapel'
        ] as $val => $label)

        <label class="cursor-pointer">
            <input
                type="checkbox"
                name="jabatan[]"
                value="{{ $val }}"
                class="hidden peer"
                data-jabatan="{{ $val }}"
            >
            <div
                class="px-3 py-2 text-xs font-bold text-center border rounded-xl
                       peer-checked:bg-indigo-600
                       peer-checked:text-white
                       transition">
                {{ $label }}
            </div>
        </label>

        @endforeach
    </div>

    {{-- BIDANG (KHUSUS WAKIL KEPALA, SATU FIELD) --}}
    <div id="bidang-wakil-wrapper" class="hidden mt-4">
        <label class="label">Bidang Wakil Kepala</label>
        <input
            type="text"
            name="bidang"
            placeholder="Contoh: Kurikulum / Kesiswaan"
            class="{{ $input }}"
        >
    </div>
</section>



                {{-- ================= MAPEL ================= --}}
                <section>
                    <h4 class="section-title">Mata Pelajaran</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input name="mapel[]" placeholder="Mapel 1" class="{{ $input }}">
                        <input name="mapel[]" placeholder="Mapel 2" class="{{ $input }}">
                    </div>
                </section>

                {{-- FOOTER --}}
                <div class="flex justify-end gap-4 pt-6 border-t">
                    <a href="{{ route('admin.guru.index') }}"
                       class="text-xs font-bold text-slate-400">
                        Batal
                    </a>
                    <button class="px-8 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black">
                        Simpan Data Guru
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<style>
.label{
    display:block;
    font-size:10px;
    font-weight:700;
    text-transform:uppercase;
    color:#64748b;
    margin-bottom:4px;
}
.section-title{
    font-size:11px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:0.12em;
    color:#334155;
    margin-bottom:16px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const wakilCheckbox = document.querySelector('input[data-jabatan="wakil_kepala"]');
    const bidangWrapper = document.getElementById('bidang-wakil-wrapper');

    if (!wakilCheckbox || !bidangWrapper) return;

    const toggleBidang = () => {
        bidangWrapper.classList.toggle('hidden', !wakilCheckbox.checked);
    };

    wakilCheckbox.addEventListener('change', toggleBidang);
    toggleBidang(); // init
});
</script>

@endsection
