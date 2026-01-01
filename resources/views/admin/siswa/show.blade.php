@extends('layouts.admin')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="min-h-screen bg-gray-50 py-6 px-4">
    <div class="max-w-4xl mx-auto">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-900">Profil Peserta Didik</h1>
                <p class="text-sm text-gray-500">Kelola informasi detail siswa secara efisien.</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.siswa.index') }}"
                   class="px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Kembali
                </a>

                {{-- TOMBOL CETAK (UI TETAP) --}}
                <button
                    type="button"
                    onclick="cetakPdfSiswa('{{ $siswa->nisn }}')"
                    class="px-3 py-2 text-sm font-medium bg-indigo-600 hover:bg-indigo-700
                           text-white rounded-lg flex items-center gap-2 shadow-sm transition">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>

                    Cetak PDF
                </button>
            </div>
        </div>

        {{-- ================= ISI DATA (TIDAK DIUBAH) ================= --}}
        <div class="grid grid-cols-1 gap-6">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        Identitas Dasar
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-4">
                        <div class="border-l-2 border-indigo-500 pl-3">
                            <dt class="text-xs font-medium text-gray-500 uppercase">Nama Lengkap</dt>
                            <dd class="text-sm font-semibold text-gray-900 mt-0.5">
                                {{ $siswa->nama_siswa }}
                            </dd>
                        </div>

                        <div class="border-l-2 border-gray-300 pl-3">
                            <dt class="text-xs font-medium text-gray-500 uppercase">NISN / NIS</dt>
                            <dd class="text-sm font-semibold text-gray-900 mt-0.5">
                                {{ $siswa->nisn }} / {{ $siswa->nis ?? '-' }}
                            </dd>
                        </div>

                        <div class="border-l-2 border-gray-300 pl-3">
                            <dt class="text-xs font-medium text-gray-500 uppercase">Jenis Kelamin</dt>
                            <dd class="text-sm font-semibold text-gray-900 mt-0.5">
                                {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </dd>
                        </div>

                        <div class="border-l-2 border-gray-300 pl-3">
                            <dt class="text-xs font-medium text-gray-500 uppercase">Tempat, Tgl Lahir</dt>
                            <dd class="text-sm font-semibold text-gray-900 mt-0.5">
                                {{ $siswa->tempat_lahir }},
                                {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->locale('id')->isoFormat('D MMMM Y') }}
                            </dd>
                        </div>

                        <div class="border-l-2 border-gray-300 pl-3">
                            <dt class="text-xs font-medium text-gray-500 uppercase">Umur</dt>
                            <dd class="text-sm font-semibold text-gray-900 mt-0.5">
                                {{ $siswa->umur }} Tahun
                            </dd>
                        </div>

                        <div class="border-l-2 border-gray-300 pl-3">
                            <dt class="text-xs font-medium text-gray-500 uppercase">Sekolah Asal</dt>
                            <dd class="text-sm font-semibold text-gray-900 mt-0.5">
                                {{ $siswa->sekolah_asal ?? '-' }}
                            </dd>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <dt class="text-xs font-medium text-gray-500 uppercase mb-1">
                            Alamat Domisili
                        </dt>
                        <dd class="text-sm text-gray-900 bg-gray-50 p-3 rounded-lg border border-gray-100 italic">
                            "{{ $siswa->alamat ?? 'Alamat belum diisi.' }}"
                        </dd>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        Informasi Keluarga & Wali
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <dt class="text-xs font-medium text-gray-400">Nama Ayah</dt>
                            <dd class="text-sm font-bold text-gray-800">{{ $siswa->ayah ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400">Nama Ibu</dt>
                            <dd class="text-sm font-bold text-gray-800">{{ $siswa->ibu ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400">Nama Wali</dt>
                            <dd class="text-sm font-bold text-gray-800">{{ $siswa->wali ?? '-' }}</dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ================= SCRIPT CETAK BASE64 ================= --}}
<script>
function cetakPdfSiswa(nisn) {
    fetch("{{ route('admin.siswa.cetak_pdf') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
        body: JSON.stringify({
            nisn: nisn
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Response tidak valid');
        }
        return response.json();
    })
    .then(data => {
        if (!data.base64) {
            throw new Error('PDF kosong');
        }

        const win = window.open('', '_blank');
        win.document.write(`
            <html>
                <head>
                    <title>Data Siswa</title>
                </head>
                <body style="margin:0">
                    <iframe
                        src="data:${data.mime};base64,${data.base64}"
                        style="border:none;width:100%;height:100vh">
                    </iframe>
                </body>
            </html>
        `);
    })
    .catch(error => {
        console.error(error);
        alert('Gagal membuat PDF');
    });
}
</script>

@endsection
