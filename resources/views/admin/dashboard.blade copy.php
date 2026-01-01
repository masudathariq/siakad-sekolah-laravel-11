@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Admin')

@section('content')

{{-- CONTAINER UTAMA DENGAN GRADIENT BIRU LAUT --}}
<div class="space-y-10">
    
{{-- GRID MENU UTAMA --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    {{-- DATA SISWA --}}
    <a href="{{ route('admin.siswa.index') }}"
       class="group bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-blue-100 rounded-lg text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
            </div>
            <span class="text-2xl">👨‍🎓</span>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Manajemen</p>
            <h3 class="text-lg font-bold text-gray-900">Data Siswa</h3>
        </div>
    </a>

    {{-- DATA GURU --}}
    <a href="{{ route('admin.guru.index') }}"
       class="group bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-green-100 rounded-lg text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <span class="text-2xl">👨‍🏫</span>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Manajemen</p>
            <h3 class="text-lg font-bold text-gray-900">Data Guru</h3>
        </div>
    </a>

    {{-- ROMBEL --}}
    <a href="{{ route('admin.tahun-ajaran.index') }}"
       class="group bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-yellow-100 rounded-lg text-yellow-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <span class="text-2xl">🏫</span>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Akademik</p>
            <h3 class="text-lg font-bold text-gray-900">Rombel</h3>
        </div>
    </a>

    {{-- ABSENSI --}}
    <a href="{{ route('admin.absen.index') }}"
       class="group bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-red-100 rounded-lg text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="text-2xl">⏱</span>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Kehadiran</p>
            <h3 class="text-lg font-bold text-gray-900">Absensi</h3>
        </div>
    </a>
</div>

{{-- SECTION SURAT --}}
<div class="mt-12">
    <div class="flex items-center gap-3 mb-6">
        <div class="h-1 w-8 bg-blue-600 rounded-full"></div>
        <h2 class="text-xl font-bold text-gray-900">Manajemen Surat</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- SURAT MASUK --}}
        <a href="{{ route('admin.surat-masuk.index') }}"
           class="group bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-cyan-100 rounded-lg text-cyan-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Arsip Masuk</p>
                    <h3 class="text-lg font-bold text-gray-900">Surat Masuk</h3>
                </div>
            </div>
        </a>

        {{-- SURAT KELUAR --}}
        <a href="{{ route('admin.surat-keluar.index') }}"
           class="group bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-blue-100 rounded-lg text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Arsip Keluar</p>
                    <h3 class="text-lg font-bold text-gray-900">Surat Keluar</h3>
                </div>
            </div>
        </a>
    </div>
</div>

{{-- SECTION STATISTIK SEMUA SISWA --}}
<div class="mt-12">
    <div class="relative overflow-hidden rounded-[3.5rem] shadow-2xl shadow-blue-200">
        
        {{-- Background Gradient Biru Laut yang Kompleks --}}
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-cyan-500 to-blue-400">
            {{-- Aksen Cahaya (Mesh Effect) --}}
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/20 rounded-full blur-[100px] -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-72 h-72 bg-blue-300/30 rounded-full blur-[80px] -ml-20 -mb-20"></div>
        </div>

        <div class="relative z-10 p-10 md:p-14 border border-white/20">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                
                {{-- Sisi Kiri: Main Stats --}}
                <div class="text-center lg:text-left text-white">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-md border border-white/30 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em]">Data Real-time</span>
                    </div>
                    
                    <h2 class="text-white/80 font-bold uppercase tracking-[0.3em] text-xs mb-2">Total Seluruh Siswa</h2>
                    <div class="flex items-center justify-center lg:justify-start gap-4">
                        <span class="text-8xl md:text-9xl font-black tracking-tighter drop-shadow-2xl">
                            {{ $regulerTotal + $pondokTotal }}
                        </span>
                    </div>
                    <p class="mt-4 text-blue-50 font-medium opacity-90">Peserta didik aktif MTs Muhammadiyah 1 Natar</p>
                </div>

                {{-- Sisi Kanan: Bento Gender Cards --}}
                <div class="w-full max-w-2xl grid grid-cols-1 sm:grid-cols-2 gap-6">
                    
                    {{-- Card Laki-laki --}}
                    <div class="group relative bg-white/10 backdrop-blur-xl border border-white/20 rounded-[2.5rem] p-8 transition-all duration-500 hover:bg-white/20 hover:scale-[1.02]">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-white text-blue-600 rounded-2xl flex items-center justify-center shadow-xl mb-6 group-hover:rotate-6 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h4 class="text-blue-50 text-xs font-bold uppercase tracking-widest mb-1">Laki-laki</h4>
                            <span class="text-5xl font-black text-white tracking-tighter">
                                {{ $regulerLaki + $pondokLaki }}
                            </span>
                            
                            {{-- Visual Indicator --}}
                            <div class="w-full mt-6 h-1.5 bg-black/10 rounded-full overflow-hidden">
                                <div class="h-full bg-white w-[60%] rounded-full shadow-[0_0_10px_white]"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Card Perempuan --}}
                    <div class="group relative bg-white/10 backdrop-blur-xl border border-white/20 rounded-[2.5rem] p-8 transition-all duration-500 hover:bg-white/20 hover:scale-[1.02]">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-white text-cyan-600 rounded-2xl flex items-center justify-center shadow-xl mb-6 group-hover:-rotate-6 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h4 class="text-blue-50 text-xs font-bold uppercase tracking-widest mb-1">Perempuan</h4>
                            <span class="text-5xl font-black text-white tracking-tighter">
                                {{ $regulerPerempuan + $pondokPerempuan }}
                            </span>

                            {{-- Visual Indicator --}}
                            <div class="w-full mt-6 h-1.5 bg-black/10 rounded-full overflow-hidden">
                                <div class="h-full bg-white w-[40%] rounded-full shadow-[0_0_10px_white]"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



{{-- JUMLAH SISWA REGULER DAN PONDOK --}}
<div class="space-y-12">
    <div class="mt-12">
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tighter italic uppercase">
                        Ringkasan <span class="text-blue-600">Jumlah</span> Siswa
                    </h3>
                    <p class="text-sm font-medium text-slate-500 mt-1">Perbandingan siswa Reguler dan Pondok</p>
                </div>

                <div class="inline-flex items-center gap-2 p-1 bg-slate-100 rounded-2xl border border-slate-200">
                    <span class="px-4 py-1.5 rounded-xl bg-blue-600 text-white text-[10px] font-bold uppercase tracking-widest shadow-md">Reguler</span>
                    <span class="px-4 py-1.5 rounded-xl bg-emerald-500 text-white text-[10px] font-bold uppercase tracking-widest shadow-md">Pondok</span>
                </div>
            </div>
            <div class="mt-6 h-1 w-full bg-slate-100 rounded-full overflow-hidden relative">
                <div class="absolute inset-y-0 left-0 w-32 bg-gradient-to-r from-blue-600 to-cyan-400"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="group relative overflow-hidden rounded-[3rem] p-1 bg-gradient-to-br from-blue-600 to-blue-400 shadow-xl shadow-blue-200">
                <div class="relative z-10 bg-white/95 rounded-[2.9rem] p-8">
                    <div class="text-center mb-6">
                        <p class="text-[11px] font-black text-blue-600 tracking-[0.3em] uppercase mb-1">REGULER</p>
                        <p class="text-6xl font-black text-slate-900 tracking-tighter italic">{{ $regulerTotal }}</p>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Siswa</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50/50 rounded-[2rem] p-5 text-center border border-blue-100 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                            <p class="text-[10px] font-bold uppercase opacity-70 mb-1 tracking-wider">Laki-laki</p>
                            <p class="text-3xl font-black italic tracking-tight">{{ $regulerLaki }}</p>
                        </div>
                        <div class="bg-rose-50/50 rounded-[2rem] p-5 text-center border border-rose-100 group-hover:bg-rose-500 group-hover:text-white transition-all duration-500">
                            <p class="text-[10px] font-bold uppercase opacity-70 mb-1 tracking-wider">Perempuan</p>
                            <p class="text-3xl font-black italic tracking-tight">{{ $regulerPerempuan }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-[3rem] p-1 bg-gradient-to-br from-emerald-500 to-cyan-400 shadow-xl shadow-emerald-200">
                <div class="relative z-10 bg-white/95 rounded-[2.9rem] p-8">
                    <div class="text-center mb-6">
                        <p class="text-[11px] font-black text-emerald-600 tracking-[0.3em] uppercase mb-1">PONDOK</p>
                        <p class="text-6xl font-black text-slate-900 tracking-tighter italic">{{ $pondokTotal }}</p>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Siswa</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50/50 rounded-[2rem] p-5 text-center border border-blue-100 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                            <p class="text-[10px] font-bold uppercase opacity-70 mb-1 tracking-wider">Laki-laki</p>
                            <p class="text-3xl font-black italic tracking-tight">{{ $pondokLaki }}</p>
                        </div>
                        <div class="bg-rose-50/50 rounded-[2rem] p-5 text-center border border-rose-100 group-hover:bg-rose-500 group-hover:text-white transition-all duration-500">
                            <p class="text-[10px] font-bold uppercase opacity-70 mb-1 tracking-wider">Perempuan</p>
                            <p class="text-3xl font-black italic tracking-tight">{{ $pondokPerempuan }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-16 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-900 rounded-[3.5rem] p-8 md:p-14 shadow-2xl shadow-blue-300 relative overflow-hidden">
        {{-- Mesh Background --}}
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-cyan-400/20 rounded-full blur-[120px] -mr-40 -mt-40"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-white/10 rounded-full blur-[100px] -ml-20 -mb-20"></div>

        <div class="relative z-10">
            <div class="mb-12 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-black text-white tracking-tighter italic uppercase">
                        Siswa Per <span class="text-cyan-300">Tingkat</span>
                    </h2>
                    <p class="text-blue-100/70 text-sm mt-2 font-medium tracking-wide">Rekapitulasi siswa berdasarkan tingkat kelas</p>
                </div>
                <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 p-2.5 rounded-[1.5rem] px-6">
                    <span class="text-[10px] font-bold text-blue-200 uppercase tracking-widest">Tahun Pelajaran</span>
                    <span class="text-xl font-black text-white italic">
                        {{ $tahunAjaranAktif ? $tahunAjaranAktif->nama : 'Belum Aktif' }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($jumlahSiswaPerTingkat as $tingkat)
                    @php
                        $laki = $tingkat->jumlah_laki;
                        $perempuan = $tingkat->jumlah_perempuan;
                        $total = $tingkat->jumlah_siswa;
                        $persenLaki = $total > 0 ? round($laki / $total * 100) : 0;
                        $persenPerempuan = 100 - $persenLaki;
                    @endphp

                    <div class="group relative bg-white/10 backdrop-blur-2xl border border-white/20 rounded-[2.5rem] p-8 hover:bg-white/20 transition-all duration-500">
                        <div class="flex justify-between items-center mb-8">
                            <div class="h-14 w-14 bg-white rounded-2xl flex items-center justify-center text-blue-600 font-black text-xl italic shadow-xl">
                                {{ $tingkat->nama }}
                            </div>
                            <div class="text-right">
                                <p class="text-4xl font-black text-white leading-none tracking-tighter italic">{{ $total }}</p>
                                <p class="text-[10px] font-bold text-blue-200/60 uppercase tracking-widest">Siswa</p>
                            </div>
                        </div>

                        <div class="mb-8 rounded-2xl px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-center
                            {{ $laki > $perempuan ? 'bg-blue-500/20 text-blue-200' : ($perempuan > $laki ? 'bg-rose-500/20 text-rose-200' : 'bg-white/10 text-white') }}">
                            @if($laki > $perempuan) Laki-laki Dominan ({{ $persenLaki }}%)
                            @elseif($perempuan > $laki) Perempuan Dominan ({{ $persenPerempuan }}%)
                            @else Jumlah Seimbang @endif
                        </div>

                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between text-[10px] font-bold text-blue-100 uppercase mb-2">
                                    <span>Laki-laki ({{ $laki }})</span>
                                    <span>{{ $persenLaki }}%</span>
                                </div>
                                <div class="h-1.5 w-full bg-black/20 rounded-full overflow-hidden">
                                    <div class="h-full bg-white rounded-full shadow-[0_0_10px_white]" style="width: {{ $persenLaki }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-[10px] font-bold text-blue-100 uppercase mb-2">
                                    <span>Perempuan ({{ $perempuan }})</span>
                                    <span>{{ $persenPerempuan }}%</span>
                                </div>
                                <div class="h-1.5 w-full bg-black/20 rounded-full overflow-hidden">
                                    <div class="h-full bg-cyan-300 rounded-full shadow-[0_0_10px_#67e8f9]" style="width: {{ $persenPerempuan }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white/5 backdrop-blur-md rounded-[2.5rem] p-16 text-center border border-dashed border-white/20">
                        <p class="text-blue-200 font-bold italic">Belum ada data siswa per tingkat</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- JUMLAH SISWA PER TINGKAT (REGULER & PONDOK) (LEBIH DETAIL)--}}

<div class="mt-16 bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-950 rounded-[4rem] p-8 md:p-12 shadow-2xl shadow-blue-900/40 relative overflow-hidden">

    <!-- Decorative blur -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-cyan-400/20 rounded-full blur-[120px] -mr-40 -mt-40 animate-pulse"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-400/10 rounded-full blur-[100px] -ml-20 -mb-20"></div>

    <div class="relative z-10">

        <!-- HEADER -->
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="relative pl-5">
                <div class="absolute left-0 top-0 h-full w-1.5 bg-gradient-to-b from-cyan-300 to-blue-500 rounded-full"></div>
                <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight uppercase">
                    Populasi <span class="text-cyan-300">Siswa</span>
                </h2>
                <p class="text-blue-100/70 text-xs mt-2 leading-relaxed">
                    Gambaran jumlah siswa Reguler dan Pondok pada setiap tingkat
                </p>
            </div>

            <div class="flex items-center bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl px-5 py-2">
                <span class="text-[11px] font-semibold text-blue-200 uppercase mr-3 tracking-wide">
                    Tahun Pelajaran
                </span>
                @if ($tahunAjaranAktif)
                    <span class="text-lg md:text-xl font-bold text-white italic">
                        {{ $tahunAjaranAktif->nama }}
                    </span>
                @else
                    <span class="text-sm font-bold text-rose-400 italic">
                        Non-Aktif
                    </span>
                @endif
            </div>
        </div>

        <!-- CONTENT -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @forelse ($jumlahSiswaPerTingkatJenis as $tingkat => $items)
                @php
                    $reguler = $items->firstWhere('jenis_rombel', 'reguler');
                    $pondok  = $items->firstWhere('jenis_rombel', 'pondok');

                    $regulerSiswa = $reguler->jumlah_siswa ?? 0;
                    $regulerLaki = $reguler->jumlah_laki ?? 0;
                    $regulerPerempuan = $reguler->jumlah_perempuan ?? 0;

                    $pondokSiswa = $pondok->jumlah_siswa ?? 0;
                    $pondokLaki = $pondok->jumlah_laki ?? 0;
                    $pondokPerempuan = $pondok->jumlah_perempuan ?? 0;

                    $totalSiswa = $regulerSiswa + $pondokSiswa;
                    $totalLaki = $regulerLaki + $pondokLaki;
                    $totalPerempuan = $regulerPerempuan + $pondokPerempuan;

                    $persenReguler = $totalSiswa > 0 ? round(($regulerSiswa / $totalSiswa) * 100) : 0;
                    $persenPondok = 100 - $persenReguler;

                    $dominanRombel = $regulerSiswa > $pondokSiswa ? 'Reguler' : ($pondokSiswa > $regulerSiswa ? 'Pondok' : 'Seimbang');
                    $dominanGender = $totalLaki > $totalPerempuan ? 'Laki-laki' : ($totalPerempuan > $totalLaki ? 'Perempuan' : 'Seimbang');
                @endphp

                <!-- CARD -->
                <div class="bg-white/10 backdrop-blur-2xl border border-white/10 rounded-[3rem] p-7">

                    <!-- TITLE -->
                    <div class="flex justify-between items-center mb-5">
                        <div class="h-14 w-14 bg-white rounded-2xl flex items-center justify-center text-blue-800 font-bold text-xl italic">
                            {{ $tingkat }}
                        </div>
                        <div class="text-right">
                            <p class="text-[11px] text-blue-200/70 uppercase tracking-wide">
                                Jumlah Siswa
                            </p>
                            <p class="text-2xl md:text-3xl font-extrabold text-white italic">
                                {{ $totalSiswa }}
                            </p>
                        </div>
                    </div>

                    <!-- SUMMARY -->
                    <div class="bg-white/5 rounded-2xl p-4 border border-white/10 mb-5">
                        <p class="text-xs md:text-sm text-white/90 leading-relaxed">
                            Tingkat <span class="font-semibold italic">{{ $tingkat }}</span> memiliki
                            <span class="font-semibold text-cyan-300">{{ $totalSiswa }}</span> siswa.
                            Mayoritas berada di kelas
                            <span class="font-semibold text-emerald-300">{{ $dominanRombel }}</span>
                            dan didominasi oleh siswa
                            <span class="font-semibold text-rose-300">{{ $dominanGender }}</span>.
                        </p>
                    </div>

                    <!-- PROGRESS -->
                    <div class="mb-5">
                        <div class="w-full h-3 bg-black/30 rounded-full overflow-hidden flex p-0.5">
                            <div class="h-full bg-blue-500 rounded-full" style="width: {{ $persenReguler }}%"></div>
                            <div class="h-full bg-emerald-500 rounded-full ml-1" style="width: {{ $persenPondok }}%"></div>
                        </div>
                        <div class="flex justify-between mt-2 text-[11px] font-semibold">
                            <span class="text-blue-300">{{ $persenReguler }}% Reguler</span>
                            <span class="text-emerald-300">{{ $persenPondok }}% Pondok</span>
                        </div>
                    </div>

                    <!-- DETAIL -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-black/20 rounded-xl p-4">
                            <p class="text-[11px] text-blue-200 uppercase mb-1">
                                Reguler
                            </p>
                            <p class="text-lg font-bold text-white">
                                {{ $regulerSiswa }}
                            </p>
                            <p class="text-[11px] text-blue-200/70 mt-1">
                                Laki-laki {{ $regulerLaki }} • Perempuan {{ $regulerPerempuan }}
                            </p>
                        </div>

                        <div class="bg-black/20 rounded-xl p-4">
                            <p class="text-[11px] text-emerald-200 uppercase mb-1">
                                Pondok
                            </p>
                            <p class="text-lg font-bold text-white">
                                {{ $pondokSiswa }}
                            </p>
                            <p class="text-[11px] text-emerald-200/70 mt-1">
                                Laki-laki {{ $pondokLaki }} • Perempuan {{ $pondokPerempuan }}
                            </p>
                        </div>
                    </div>

                </div>

            @empty
                <div class="col-span-full bg-white/5 rounded-[3rem] p-20 text-center border border-dashed border-white/20">
                    <p class="text-sm text-blue-200 font-semibold uppercase tracking-widest">
                        Data Populasi Belum Tersedia
                    </p>
                </div>
            @endforelse

        </div>
    </div>
</div>



{{-- STATISTIK JUMLAH SISWA PER ROMBEL --}}
<div class="mt-14 mb-12">
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6 relative">
        <div class="relative z-10">
            <div class="flex items-center gap-4 mb-3">
                <div class="w-3 h-10 bg-gradient-to-b from-cyan-400 to-blue-600 rounded-full shadow-[0_0_15px_rgba(34,211,238,0.4)]"></div>
                <h2 class="text-3xl font-black text-slate-800 tracking-tighter italic uppercase">
                    Kapasitas <span class="text-blue-600">Rombel</span>
                </h2>
            </div>
            <div class="inline-flex items-center gap-3 px-4 py-2 rounded-[1.2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/50">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tahun Ajaran</span>
                @if ($tahunAjaranAktif)
                    <span class="text-sm font-black text-blue-600 italic tracking-tight">{{ $tahunAjaranAktif->nama }}</span>
                @else
                    <span class="text-sm font-black text-rose-500 italic">Non-Aktif</span>
                @endif
            </div>
        </div>
        
        <div class="flex gap-6 text-right relative z-10">
            <div class="bg-blue-50/50 px-4 py-2 rounded-2xl border border-blue-100">
                <p class="text-[9px] font-black text-blue-400 uppercase tracking-widest mb-0.5 text-center">Status Data</p>
                <div class="flex items-center gap-2">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                    </span>
                    <p class="text-xs font-black text-slate-600 uppercase italic">Real-time Sync</p>
                </div>
            </div>
        </div>
    </div>

    @forelse($jumlahSiswaPerRombel as $namaTingkat => $rombels)
        <div class="mb-20 last:mb-0">
            <div class="flex items-center gap-6 mb-10 group">
                <div class="flex-none w-16 h-16 rounded-[1.8rem] bg-gradient-to-br from-blue-700 to-indigo-900 flex items-center justify-center text-white shadow-2xl shadow-blue-200 group-hover:scale-110 transition-transform duration-500 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 opacity-50"></div>
                    <span class="text-2xl font-black italic relative z-10">{{ $namaTingkat }}</span>
                </div>
                <div class="flex-1 h-[2px] bg-gradient-to-r from-blue-100 via-blue-50 to-transparent"></div>
                <span class="text-[11px] font-black text-blue-300 uppercase tracking-[0.4em] italic">Tingkat Kelas</span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-8">
                @foreach($rombels as $rombel)
                    @php
                        $total = $rombel->jumlah_siswa;
                        $laki = $rombel->jumlah_laki;
                        $perempuan = $rombel->jumlah_perempuan;
                        $persenLaki = $total > 0 ? round($laki / $total * 100) : 0;
                    @endphp

                    <div class="group relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-[3rem] p-7 flex flex-col items-center justify-between transition-all duration-500 hover:shadow-[0_25px_50px_-12px_rgba(30,58,138,0.5)] hover:-translate-y-3 border border-white/10 overflow-hidden">
                        
                        <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="w-full text-center relative z-10">
                            <span class="text-[9px] font-black text-blue-200/60 uppercase tracking-[0.2em] block mb-2">Rombel</span>
                            <div class="inline-block px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 group-hover:bg-white transition-all duration-500">
                                <h4 class="text-xs font-black text-white group-hover:text-blue-700 transition-colors uppercase tracking-tight">
                                    {{ $rombel->rombel_nama }}
                                </h4>
                            </div>
                        </div>

                        <div class="my-6 relative z-10 text-center">
                            <div class="absolute inset-0 bg-cyan-400 rounded-full scale-[2] blur-[30px] opacity-20 group-hover:opacity-40 transition-all duration-700"></div>
                            <span class="relative text-6xl font-black text-white tracking-tighter leading-none italic drop-shadow-lg">
                                {{ $total }}
                            </span>
                        </div>

                        <div class="w-full space-y-3 relative z-10">
                            <div class="w-full h-2 bg-black/20 rounded-full overflow-hidden flex p-0.5 border border-white/10 shadow-inner">
                                <div class="h-full bg-white rounded-full transition-all duration-1000 shadow-[0_0_8px_rgba(255,255,255,0.8)]" style="width: {{ $persenLaki }}%"></div>
                                <div class="h-full bg-cyan-400 rounded-full transition-all duration-1000 ml-0.5 shadow-[0_0_8px_rgba(34,211,238,0.8)]" style="width: {{ 100 - $persenLaki }}%"></div>
                            </div>
                            
                            <div class="flex justify-between items-center text-[10px] font-black italic tracking-tighter">
                                <span class="text-white">{{ $laki }} L</span>
                                <div class="w-1 h-1 bg-white/30 rounded-full"></div>
                                <span class="text-cyan-300">{{ $perempuan }} P</span>
                            </div>
                        </div>

                        <div class="absolute top-2 right-4 text-white/20 text-xl font-black italic select-none">≈</div>
                    </div>
                @endforeach
            </div>
        </div>

    @empty
        <div class="bg-gradient-to-br from-blue-900 to-indigo-950 rounded-[4rem] p-24 text-center border border-white/10 shadow-2xl">
            <div class="w-28 h-28 bg-white/10 backdrop-blur-xl rounded-[2.5rem] shadow-xl flex items-center justify-center mx-auto mb-8 transform -rotate-12 border border-white/20">
                <svg class="w-12 h-12 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h3 class="text-2xl font-black text-white italic uppercase tracking-tight">Data Rombel Kosong</h3>
            <p class="text-[10px] font-black text-blue-200/60 uppercase tracking-[0.3em] mt-3 italic">Segera sinkronisasi data pada dashboard utama</p>
        </div>
    @endforelse
</div>


{{-- PEMBAGIAN UMUR --}}
<div class="mt-12">
    <div class="mb-12 flex items-center justify-between gap-6 relative">
        <div class="relative z-10">
            <h3 class="text-2xl font-black text-slate-800 tracking-tighter italic uppercase flex items-center gap-3">
                <div class="p-2 bg-blue-600 rounded-xl shadow-lg shadow-blue-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                Distribusi <span class="text-blue-600">Umur Siswa</span>
            </h3>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-2 ml-14">Analisis demografi siswa berdasarkan usia dan jenjang kelas</p>
        </div>
        <div class="hidden md:block h-[2px] flex-1 bg-gradient-to-r from-blue-100 to-transparent mx-8"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        @foreach($siswaPerTingkatUmur as $tingkat => $umurData)
            <div class="group relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-900 border border-white/10 rounded-[3rem] p-8 shadow-2xl shadow-blue-900/20 transition-all duration-500 hover:-translate-y-2 overflow-hidden">
                
                <div class="absolute -right-4 -top-4 text-white/5 text-8xl font-black italic select-none">
                    {{ $tingkat }}
                </div>

                <div class="flex items-center justify-between mb-8 relative z-10">
                    <div>
                        <span class="text-[10px] font-black text-blue-200/60 uppercase tracking-[0.2em] block mb-1">Tingkat Kelas</span>
                        <h4 class="text-3xl font-black text-white italic tracking-tighter leading-none">{{ $tingkat }}</h4>
                    </div>
                    <div class="w-14 h-14 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl flex items-center justify-center group-hover:bg-white group-hover:scale-110 transition-all duration-500">
                        <span class="text-[10px] font-black text-white group-hover:text-blue-700 uppercase italic">LVL</span>
                    </div>
                </div>

                <div class="space-y-4 relative z-10">
                    @foreach($umurData as $umur => $jumlah)
                        <div class="relative overflow-hidden bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-4 flex items-center justify-between group/item hover:bg-white/10 transition-colors">
                            <div class="absolute inset-y-0 left-0 bg-cyan-400/10 transition-all duration-700 w-full transform -translate-x-full group-hover:translate-x-0"></div>

                            <div class="relative z-10">
                                <p class="text-[9px] font-black text-blue-200/50 uppercase leading-none mb-1 tracking-widest">Kategori Umur</p>
                                <p class="text-sm font-black text-white italic tracking-tight">
                                    {{ $umur }} <span class="text-[10px] font-medium text-cyan-300/70 ml-1">Tahun</span>
                                </p>
                            </div>

                            <div class="relative z-10 text-right">
                                <div class="flex items-baseline justify-end gap-1">
                                    <span class="text-3xl font-black text-white italic tracking-tighter group-hover/item:text-cyan-300 transition-colors">
                                        {{ $jumlah }}
                                    </span>
                                    <span class="text-[9px] font-black text-blue-200/50 uppercase italic">Siswa</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 pt-6 border-t border-white/10 flex justify-between items-center relative z-10">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></div>
                        <span class="text-[10px] font-black text-blue-200/40 uppercase italic tracking-widest">Statistik Real-time</span>
                    </div>
                    <div class="flex -space-x-3">
                        <div class="w-7 h-7 rounded-full border-2 border-blue-700 bg-blue-500 shadow-lg"></div>
                        <div class="w-7 h-7 rounded-full border-2 border-blue-700 bg-cyan-400 shadow-lg"></div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>


{{-- DATA GURU --}}
<div class="py-8 px-4">
    <div class="mb-8 relative">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-800 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tighter italic uppercase">
                    Ringkasan <span class="text-blue-600">Data Guru</span>
                </h2>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em] mt-1">Matriks Kepegawaian & Kualifikasi Pendidikan</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        
        <div class="relative bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-950 rounded-[2.5rem] p-6 shadow-2xl shadow-blue-900/30 group overflow-hidden border border-white/10">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/5 rounded-full blur-3xl group-hover:bg-cyan-400/20 transition-colors duration-700"></div>
            <div class="relative z-10">
                <p class="text-blue-200/60 text-[10px] font-black uppercase tracking-widest mb-2">Total Personel</p>
                <div class="flex items-baseline gap-3">
                    <span class="text-5xl font-black text-white italic tracking-tighter">{{ $totalGuru }}</span>
                    <span class="text-cyan-300 text-xs font-black uppercase tracking-widest">Orang</span>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <span class="w-8 h-1 bg-cyan-400 rounded-full"></span>
                    <span class="text-[9px] text-blue-100/50 font-bold uppercase">Update Real-time</span>
                </div>
            </div>
            <svg class="absolute right-6 top-6 w-12 h-12 text-white/5" fill="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>

        <div class="relative bg-gradient-to-br from-blue-500 to-blue-700 rounded-[2.5rem] p-6 shadow-xl shadow-blue-200/50 group border border-white/10">
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-white/70 text-[10px] font-black uppercase tracking-widest mb-1">Guru Laki-Laki</p>
                    <span class="text-4xl font-black text-white italic tracking-tighter">{{ $totalL }}</span>
                </div>
                <div class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white text-xl font-black shadow-inner">L</div>
            </div>
            <div class="mt-4 bg-white/10 rounded-full h-1.5 overflow-hidden">
                <div class="bg-white h-full" style="width: {{ $totalGuru > 0 ? ($totalL/$totalGuru)*100 : 0 }}%"></div>
            </div>
        </div>

        <div class="relative bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-[2.5rem] p-6 shadow-xl shadow-indigo-200/50 group border border-white/10">
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-white/70 text-[10px] font-black uppercase tracking-widest mb-1">Guru Perempuan</p>
                    <span class="text-4xl font-black text-white italic tracking-tighter">{{ $totalP }}</span>
                </div>
                <div class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white text-xl font-black shadow-inner">P</div>
            </div>
            <div class="mt-4 bg-white/10 rounded-full h-1.5 overflow-hidden">
                <div class="bg-cyan-300 h-full" style="width: {{ $totalGuru > 0 ? ($totalP/$totalGuru)*100 : 0 }}%"></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 bg-gradient-to-r from-slate-50 to-white flex items-center justify-between">
            <h3 class="text-xs font-black text-slate-700 uppercase tracking-[0.2em] italic flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                Matriks Pendidikan & Status Yayasan
            </h3>
            <span class="px-4 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-full uppercase tracking-widest">Detail View</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase border-b border-r border-slate-100">Jenjang</th>
                        <th colspan="3" class="px-4 py-3 text-[10px] font-black text-blue-600 uppercase text-center border-b border-r border-blue-100 bg-blue-50/50 italic tracking-widest">Total Global</th>
                        <th colspan="3" class="px-4 py-3 text-[10px] font-black text-emerald-600 uppercase text-center border-b border-r border-emerald-100 bg-emerald-50/50 italic tracking-widest">Tetap (GTY)</th>
                        <th colspan="3" class="px-4 py-3 text-[10px] font-black text-amber-600 uppercase text-center border-b bg-amber-50/50 italic tracking-widest">Tidak Tetap (GTTY)</th>
                    </tr>
                    <tr class="bg-white/80">
                        <th class="px-6 py-2 border-r border-slate-100"></th>
                        <th class="px-3 py-3 text-[9px] font-black text-slate-400 text-center border-r border-slate-50">Σ</th>
                        <th class="px-3 py-3 text-[9px] font-black text-blue-400 text-center border-r border-slate-50">L</th>
                        <th class="px-3 py-3 text-[9px] font-black text-rose-400 text-center border-r border-slate-200">P</th>
                        <th class="px-3 py-3 text-[9px] font-black text-emerald-500 text-center border-r border-emerald-50">Σ</th>
                        <th class="px-3 py-3 text-[9px] font-black text-emerald-500 text-center border-r border-emerald-50">L</th>
                        <th class="px-3 py-3 text-[9px] font-black text-emerald-500 text-center border-r border-slate-200">P</th>
                        <th class="px-3 py-3 text-[9px] font-black text-amber-500 text-center border-r border-amber-50">Σ</th>
                        <th class="px-3 py-3 text-[9px] font-black text-amber-500 text-center border-r border-amber-50">L</th>
                        <th class="px-3 py-3 text-[9px] font-black text-amber-500 text-center">P</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($statistik['pendidikan'] as $pd => $data)
                    <tr class="hover:bg-blue-50/30 transition-all group">
                        <td class="px-6 py-4 text-xs font-black text-slate-700 border-r border-slate-100 group-hover:text-blue-600 transition-colors uppercase italic">{{ $pd }}</td>
                        
                        <td class="px-3 py-4 text-sm font-black text-slate-900 text-center border-r border-slate-50">{{ $data['total'] }}</td>
                        <td class="px-3 py-4 text-xs font-bold text-slate-600 text-center border-r border-slate-50">{{ $data['l'] }}</td>
                        <td class="px-3 py-4 text-xs font-bold text-slate-600 text-center border-r border-slate-200">{{ $data['p'] }}</td>
                        
                        <td class="px-3 py-4 text-sm font-black text-emerald-700 text-center border-r border-emerald-50 bg-emerald-50/10">{{ $data['gty_total'] }}</td>
                        <td class="px-3 py-4 text-xs font-bold text-emerald-600 text-center border-r border-emerald-50 bg-emerald-50/10">{{ $data['gty_l'] }}</td>
                        <td class="px-3 py-4 text-xs font-bold text-emerald-600 text-center border-r border-slate-200 bg-emerald-50/10">{{ $data['gty_p'] }}</td>
                        
                        <td class="px-3 py-4 text-sm font-black text-amber-700 text-center border-r border-amber-50 bg-amber-50/10">{{ $data['gtty_total'] }}</td>
                        <td class="px-3 py-4 text-xs font-bold text-amber-600 text-center border-r border-amber-50 bg-amber-50/10">{{ $data['gtty_l'] }}</td>
                        <td class="px-3 py-4 text-xs font-bold text-amber-600 text-center bg-amber-50/10">{{ $data['gtty_p'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 bg-slate-50 flex justify-center border-t border-slate-100">
             <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Sistem Informasi Manajemen Kepegawaian v2.0</p>
        </div>
    </div>
</div>

@endsection



