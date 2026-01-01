@extends('layouts.admin')

@section('title', 'Detail Guru')

@php
if (!function_exists('infoRow')) {
    function infoRow($label, $value) {
        return '
        <div class="flex items-center justify-between py-2 border-b border-slate-100">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">'.$label.'</span>
            <span class="text-xs font-semibold text-slate-700">'.$value.'</span>
        </div>';
    }
}
@endphp

@section('content')
<div class="py-6 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl shadow-lg flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-black text-slate-800 tracking-tight">Profil Pengajar</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Detail Lengkap Guru</p>
                </div>
            </div>

            {{-- Tombol aksi --}}
            <div class="flex gap-2">
                <a href="{{ route('admin.guru.index') }}"
                    class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-[9px] font-black text-slate-500 uppercase tracking-tighter hover:bg-slate-50 shadow-sm transition">
                    Kembali
                </a>
                <a href="{{ route('admin.guru.edit', $guru->id) }}"
                    class="px-3 py-2 bg-slate-900 rounded-lg text-[9px] font-black text-white uppercase tracking-tighter hover:bg-indigo-600 shadow-sm transition">
                    Edit Data
                </a>
                <form id="cetakPdfForm" action="{{ route('admin.guru.cetak.base64', $guru->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-3 py-2 bg-indigo-600 text-white font-black text-[9px] uppercase rounded-lg shadow hover:bg-indigo-700 transition">
                        Cetak PDF
                    </button>
                </form>
            </div>
        </div>

        {{-- KARTU PROFIL --}}
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">

            {{-- Header kartu --}}
            <div class="bg-slate-50 border-b border-slate-100 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-tr from-slate-200 to-slate-100 rounded-2xl flex items-center justify-center border-4 border-white shadow-inner">
                        <span class="text-xl font-black text-slate-400 uppercase">{{ substr($guru->nama, 0, 2) }}</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-800 leading-none mb-1">{{ $guru->nama }}</h2>
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase rounded-md border border-indigo-100">{{ $guru->id_guru }}</span>
                            <span class="text-[10px] font-bold text-slate-400">• {{ $guru->status_kepegawaian == 'GTY' ? 'Tetap' : 'Tidak Tetap' }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-6 px-4">
                    <div class="text-center">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Masa Kerja</p>
                        <p class="text-xs font-black text-slate-700">{{ $guru->masa_kerja ?? '0 Thn' }}</p>
                    </div>
                    <div class="w-px h-8 bg-slate-200"></div>
                    <div class="text-center">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Status</p>
                        <div class="flex items-center justify-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full {{ $guru->status ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                            <span class="text-xs font-black text-slate-700 uppercase">{{ $guru->status ? 'Aktif' : 'Non-Aktif' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail --}}
            <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">

                {{-- Kolom kiri --}}
                <div class="space-y-8">
                    {{-- Identitas --}}
                    <div class="space-y-4">
                        <h4 class="text-[10px] font-black text-indigo-600 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-4 h-[2px] bg-indigo-600"></span> Identitas Personal
                        </h4>
                        <div class="grid grid-cols-1 gap-y-3">
                            {!! infoRow("Jenis Kelamin", $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') !!}
                            {!! infoRow("Tempat, Tgl Lahir", ($guru->tempat_lahir ?? '-') . ', ' . ($guru->tanggal_lahir ? $guru->tanggal_lahir->format('d/m/Y') : '-')) !!}
                            {!! infoRow("Pendidikan", $guru->pendidikan ?? '-') !!}
                            {!! infoRow("Jurusan", $guru->jurusan ?? '-') !!}
                        </div>
                    </div>

                    {{-- Legalitas --}}
                    <div class="space-y-4">
                        <h4 class="text-[10px] font-black text-emerald-600 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-4 h-[2px] bg-emerald-600"></span> Legalitas
                        </h4>
                        <div class="grid grid-cols-1 gap-y-3">
                            {!! infoRow("NBM", $guru->nbm ?? '-') !!}
                            {!! infoRow("NUPTK", $guru->nuptk ?? '-') !!}
                            {!! infoRow("Sertifikasi", strtoupper($guru->status_sertifikasi)) !!}
                        </div>
                    </div>
                </div>

                {{-- Kolom kanan --}}
                <div class="space-y-8">
                    {{-- Jabatan & Mapel --}}
                    <div class="space-y-4">
                        <h4 class="text-[10px] font-black text-amber-500 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-4 h-[2px] bg-amber-500"></span> Jabatan & Mata Pelajaran
                        </h4>
                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                            <p class="text-[9px] font-bold text-slate-400 uppercase mb-2">Struktur Organisasi</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($guru->jabatans as $jab)
                                    <span class="px-3 py-1 bg-white border border-slate-200 text-[10px] font-black text-slate-700 rounded-lg shadow-sm">
                                        {{ ucwords(str_replace('_', ' ', $jab->jabatan)) }}
                                        @if($jab->bidang) <span class="text-indigo-500 text-[9px]">({{ $jab->bidang }})</span> @endif
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                            <p class="text-[9px] font-bold text-slate-400 uppercase mb-2">Mata Pelajaran Diampu</p>
                            <div class="flex flex-wrap gap-1.5">
                                @forelse($guru->mapels as $mapel)
                                    <span class="px-2.5 py-1 bg-indigo-600 text-white text-[9px] font-bold rounded-md">{{ $mapel->nama_mapel }}</span>
                                @empty
                                    <span class="text-[10px] text-slate-400 italic">Belum ada mapel</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Riwayat Kerja --}}
                    <div class="space-y-4">
                        <h4 class="text-[10px] font-black text-rose-500 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-4 h-[2px] bg-rose-500"></span> Riwayat Kerja
                        </h4>
                        <div class="grid grid-cols-1 gap-y-3">
                            {!! infoRow("TMT", $guru->tmt ? $guru->tmt->format('d F Y') : '-') !!}
                            {!! infoRow("Lama Mengabdi", $guru->masa_kerja ?? '-') !!}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="bg-slate-50/50 p-4 border-t border-slate-100">
                <p class="text-[9px] text-center font-bold text-slate-400 uppercase tracking-widest">Data terakhir diperbarui: {{ $guru->updated_at->format('d/m/Y H:i') }}</p>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('cetakPdfForm');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const url = form.action;

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if(data.success) {
                // Buka PDF di tab baru full screen
                const pdfWindow = window.open("");
                pdfWindow.document.write(
                    `<iframe width='100%' height='100%' src='data:application/pdf;base64,${data.base64}'></iframe>`
                );
            } else {
                alert('Gagal membuat PDF!');
            }

        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan server!');
        }
    });
});
</script>
@endsection
