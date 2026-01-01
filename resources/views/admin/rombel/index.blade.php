@extends('layouts.admin')

@section('page-title', 'Manajemen Rombel')

@section('content')
<div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
    @if(!isset($tahunAjaran))
        <div class="min-h-[60vh] flex flex-col items-center justify-center p-6 text-center">
            <h1 class="text-sm font-black text-slate-800 uppercase italic">Tahun Ajaran Tidak Aktif</h1>
            <a href="{{ route('admin.tahun-ajaran.index') }}" class="mt-4 px-6 py-2 bg-slate-900 text-white text-[9px] font-bold uppercase tracking-widest rounded-xl">Pilih Periode</a>
        </div>
    @else
    <div class="max-w-full mx-auto py-6 px-6"> 
        
        {{-- HEADER RINGKAS --}}
        <div class="mb-8 flex flex-col md:flex-row justify-between items-end gap-4">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-2 h-6 bg-slate-900 rounded-full"></div>
                    <h1 class="text-xl font-black text-slate-800 uppercase italic tracking-tighter">Data Rombel</h1>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] ml-5">Periode Akademik: <span class="text-blue-600">{{ $tahunAjaran->nama }}</span></p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.tahun-ajaran.index') }}" class="px-4 py-2 text-[9px] font-black text-slate-500 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all uppercase">
                    KEMBALI
                </a>
                <a href="{{ route('admin.rombel.create', ['tahun_ajaran' => $tahunAjaran->id]) }}"
                   class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 text-white font-black text-[9px] uppercase tracking-widest rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                    TAMBAH KELAS
                </a>
                <a href="{{ route('admin.cetak_daftarhadir_siswa.form') }}"
                   class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 text-white font-black text-[9px] uppercase tracking-widest rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                    CETAK DAFTAR HADIR SISWA
                </a>
                
            </div>
        </div>

        @php
            $groupedRombels = collect($rombels)->sortBy('tingkat_id')->groupBy('tingkat_id');
        @endphp

        @forelse($groupedRombels as $tingkatId => $rombelList)
            @php
                $tingkatNama = strtoupper($rombelList->first()->tingkat->nama ?? '');
                
                // PEMBEDA WARNA SOLID PER TINGKAT
                if (str_contains($tingkatNama, 'VII') && !str_contains($tingkatNama, 'VIII')) {
                    $theme = ['bg' => 'bg-blue-600', 'btn' => 'text-blue-600']; 
                } elseif (str_contains($tingkatNama, 'VIII')) {
                    $theme = ['bg' => 'bg-emerald-600', 'btn' => 'text-emerald-600'];
                } elseif (str_contains($tingkatNama, 'IX')) {
                    $theme = ['bg' => 'bg-rose-600', 'btn' => 'text-rose-600'];
                } else {
                    $theme = ['bg' => 'bg-slate-700', 'btn' => 'text-slate-700'];
                }
            @endphp

            <div class="mb-10">
                <div class="flex items-center gap-3 mb-5 px-1">
                    <span class="text-[10px] font-black text-slate-800 uppercase tracking-[0.3em] italic">Tingkat {{ $tingkatNama }}</span>
                    <div class="flex-1 h-[1px] bg-slate-200"></div>
                    <span class="text-[8px] font-bold text-slate-400 uppercase">{{ $rombelList->count() }} Kelas</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    @foreach($rombelList->sortBy('kode_kelas') as $rombel)
                        <div class="group relative {{ $theme['bg'] }} p-5 rounded-[1.5rem] shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden border border-white/10">
                            
                            <div class="absolute -right-2 -top-2 w-16 h-16 bg-white/5 rounded-full group-hover:scale-150 transition-transform"></div>

                            <div class="relative z-10">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="text-[7px] font-black bg-black/20 text-white px-2 py-0.5 rounded-md uppercase tracking-widest border border-white/5">
                                        {{ $rombel->jenis_rombel ?? 'REG' }}
                                    </span>
                                    <div class="w-6 h-6 bg-white/10 rounded-lg flex items-center justify-center border border-white/10">
                                        <span class="text-[10px] font-black text-white italic">{{ substr($rombel->kode_kelas, 0, 1) }}</span>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <h3 class="text-sm font-black text-white leading-tight uppercase italic truncate tracking-tight">
                                        {{ $rombel->kode_kelas }}
                                    </h3>
                                    <p class="text-[8px] font-bold text-white/40 uppercase tracking-widest mt-1 truncate">
                                        {{ $rombel->nama_kelas ?? 'GENERAL' }}
                                    </p>
                                </div>

                                <div class="flex items-end justify-between mb-5">
                                    <div class="flex flex-col">
                                        <span class="text-[7px] font-black text-white/40 uppercase">Siswa</span>
                                        <span class="text-base font-black text-white leading-none italic tracking-tighter">{{ $rombel->siswas->count() }}</span>
                                    </div>
                                    <div class="h-6 w-[1px] bg-white/10"></div>
                                    <div class="flex flex-col items-end">
                                        <span class="text-[7px] font-black text-white/40 uppercase">Status</span>
                                        <span class="text-[8px] font-black text-emerald-400 uppercase italic">Aktif</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-5 gap-1.5">
                                    <a href="{{ route('admin.rombel.show', $rombel->id) }}" 
                                       class="col-span-4 py-2 bg-white {{ $theme['btn'] }} text-[8px] font-black uppercase tracking-widest rounded-xl text-center shadow-md hover:bg-cyan-50 transition-all">
                                        BUKA DATA
                                    </a>
                                    <a href="{{ route('admin.rombel.edit', $rombel->id) }}" 
                                       class="flex items-center justify-center bg-black/20 text-white rounded-xl hover:bg-black/40 transition-all border border-white/5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center py-20 bg-white rounded-[2rem] border-2 border-dashed border-slate-100 mt-4">
                <p class="text-slate-300 font-black uppercase text-[10px] tracking-[0.5em] italic">Database Rombel Kosong</p>
            </div>
        @endforelse
    </div>
    </div>
    @endif
@endsection