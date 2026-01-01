@extends('layouts.admin')

@section('page-title', 'Manajemen Tahun Ajaran')

@section('content')
<div class="min-h-screen bg-slate-50/50 py-6 px-4">
    <div class="max-w-[1400px] mx-auto">

        {{-- COMPACT HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
                <div>
                    <h1 class="text-lg font-black text-slate-800 tracking-tighter italic uppercase leading-none">
                        Periode <span class="text-blue-600">Akademik</span>
                    </h1>
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">Konfigurasi & Kontrol Rombel</p>
                </div>
            </div>
            
            <a href="{{ route('admin.tahun-ajaran.create') }}"
               class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-slate-900 text-white rounded-xl transition-all hover:bg-blue-600 active:scale-95 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span class="text-[9px] font-black uppercase tracking-widest italic">Tambah Periode</span>
            </a>
        </div>

        {{-- HIGH DENSITY GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse($tahunAjarans as $ta)
                @php
                    $isAktif = $ta->aktif;
                    $bgClass = $isAktif ? 'bg-blue-600' : 'bg-slate-800';
                    $accentText = $isAktif ? 'text-blue-600' : 'text-slate-800';
                @endphp

                <div class="group relative {{ $bgClass }} rounded-[2rem] p-5 transition-all duration-300 hover:-translate-y-1 shadow-md hover:shadow-xl overflow-hidden border border-white/10">
                    
                    {{-- Decorative Subtle Light --}}
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-xl group-hover:scale-150 transition-transform"></div>
                    
                    <div class="relative z-10">
                        <div class="flex justify-between items-center mb-6">
                            <div class="w-8 h-8 rounded-lg bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            
                            @if($isAktif)
                                <span class="flex items-center gap-1.5 bg-white px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-tighter {{ $accentText }} shadow-sm">
                                    <span class="relative flex h-1.5 w-1.5">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-blue-600"></span>
                                    </span>
                                    Aktif
                                </span>
                            @else
                                <span class="bg-black/20 px-3 py-1 rounded-full text-[8px] font-black uppercase text-white/50 border border-white/5">
                                    Arsip
                                </span>
                            @endif
                        </div>

                        <div class="mb-6">
                            <span class="text-[7px] font-black text-white/40 uppercase tracking-[0.2em] block mb-1">Tahun Ajaran</span>
                            <h3 class="text-2xl font-black text-white italic tracking-tighter leading-none">{{ $ta->nama }}</h3>
                            <p class="text-[8px] font-medium text-white/50 mt-2 italic leading-relaxed">
                                {{ $isAktif ? 'Periode operasional sistem saat ini' : 'Riwayat data akademik tersimpan' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-5 gap-2">
                            <a href="{{ route('admin.rombel.index', ['tahun_ajaran' => $ta->id]) }}"
                               class="col-span-4 py-2 rounded-xl text-center text-[9px] font-black uppercase tracking-tighter bg-white {{ $accentText }} hover:bg-cyan-400 hover:text-white transition-all shadow-sm flex items-center justify-center gap-1">
                                Kelola Rombel
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                            <a href="{{ route('admin.tahun-ajaran.edit', $ta->id) }}"
                               class="flex items-center justify-center rounded-xl border border-white/20 text-white hover:bg-white/10 transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 bg-white rounded-3xl border-2 border-dashed border-slate-100 text-center shadow-inner">
                    <p class="text-[10px] font-black text-slate-300 uppercase italic tracking-widest">Belum ada periode yang dibuat</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection