@extends('layouts.admin')

@section('page-title', 'Data Alumni')

@section('content')
<div class="max-w-full mx-auto px-6 py-6">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                {{-- Solid Blue --}}
                <div class="w-1.5 h-8 rounded-full" style="background-color: #0000FF;"></div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tighter italic uppercase leading-none">
                    Data <span style="color: #0000FF;">Alumni</span>
                </h2>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-5 italic">Sistem Informasi Kelulusan</p>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="px-5 py-2.5 bg-white rounded-2xl border border-slate-200 shadow-sm flex items-center gap-3">
                <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Total Record:</span>
                <span class="text-lg font-black italic leading-none" style="color: #0000FF;">{{ count($alumnis) }}</span>
            </div>
        </div>
    </div>

    <div class="px-8 py-4 border-b border-slate-100 bg-slate-50">
    <form method="GET" action="{{ route('admin.alumni.index') }}" class="flex flex-wrap items-end gap-3">
        
        {{-- FILTER TAHUN AJARAN --}}
        <div class="flex flex-col">
            <label class="text-[8px] font-black uppercase tracking-widest text-slate-400 mb-1">
                Tahun Ajaran
            </label>
            <select name="tahun_ajaran_id"
                class="px-4 py-2 rounded-xl border border-slate-200 text-[10px] font-bold focus:ring-2 focus:ring-blue-500">
                <option value="">-- Semua --</option>
                @foreach($tahunAjarans as $ta)
                    <option value="{{ $ta->id }}"
                        {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                        {{ $ta->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- TOMBOL FILTER --}}
        <button type="submit"
            class="px-5 py-2.5 rounded-xl font-black text-[10px] uppercase tracking-widest shadow"
            style="background:#0000FF;color:white">
            Filter
        </button>

        {{-- TOMBOL CETAK --}}
        <a href="{{ route('admin.alumni.cetak', request()->query()) }}"
           target="_blank"
           class="px-5 py-2.5 rounded-xl font-black text-[10px] uppercase tracking-widest border border-blue-600 text-blue-600 bg-white hover:bg-blue-50">
            Cetak
        </a>
    </form>
</div>


    {{-- TABLE CONTAINER --}}
    <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden">
        
        <div class="px-8 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full" style="background-color: #0000FF;"></div>
                <h3 class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] italic">Tabel Master Alumni</h3>
            </div>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr style="background-color: #0000FF;">
                        <th class="px-6 py-4 text-[9px] font-black uppercase tracking-widest text-center" style="color: #FFFFFF;">No</th>
                        <th class="px-4 py-4 text-[9px] font-black uppercase tracking-widest border-l border-white/10 italic" style="color: #FFFFFF;">Identitas Siswa</th>
                        <th class="px-4 py-4 text-[9px] font-black uppercase tracking-widest border-l border-white/10 italic" style="color: #FFFFFF;">Lahir & Gender</th>
                        <th class="px-4 py-4 text-[9px] font-black uppercase tracking-widest border-l border-white/10 italic" style="color: #FFFFFF;">Data Wali</th>
                        <th class="px-4 py-4 text-[9px] font-black uppercase tracking-widest border-l border-white/10 italic text-center" style="color: #FFFFFF;">Riwayat Lulus</th>
                        <th class="px-6 py-4 text-[9px] font-black uppercase tracking-widest border-l border-white/10 text-right" style="color: #FFFFFF;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($alumnis as $alumni)
                        <tr class="hover:bg-blue-50 transition-colors group">
                            <td class="px-6 py-4 text-center">
                                <span class="text-[10px] font-black text-slate-300 italic group-hover:text-blue-600">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-col">
                                    <span class="text-[11px] font-black text-slate-800 uppercase italic tracking-tight group-hover:text-blue-700">
                                        {{ $alumni->nama_siswa }}
                                    </span>
                                    <span class="text-[8px] font-bold text-slate-400 mt-0.5 tracking-widest">NISN: {{ $alumni->nisn }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="px-1.5 py-0.5 rounded bg-slate-100 text-[8px] font-black text-slate-600 uppercase">{{ $alumni->jenis_kelamin }}</span>
                                        <span class="text-[9px] font-bold text-slate-500 italic">{{ $alumni->tempat_lahir ?? '-' }}</span>
                                    </div>
                                    <span class="text-[8px] font-black uppercase mt-0.5 opacity-60" style="color: #0000FF;">
                                        {{ $alumni->tanggal_lahir?->format('d M Y') ?? '-' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="grid grid-cols-1 gap-0.5 text-[8px] text-slate-500 font-bold uppercase italic leading-tight">
                                    <div class="flex items-center gap-1"><span class="font-black not-italic" style="color: #0000FF; opacity: 0.4;">A:</span> {{ $alumni->ayah ?? '-' }}</div>
                                    <div class="flex items-center gap-1"><span class="font-black not-italic" style="color: #0000FF; opacity: 0.4;">I:</span> {{ $alumni->ibu ?? '-' }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="inline-flex flex-col px-3 py-1 rounded-xl border border-blue-100" style="background-color: #eff6ff;">
                                    <span class="text-[9px] font-black uppercase italic leading-none" style="color: #0000FF;">
                                        {{ $alumni->tahunAjaran->nama ?? '-' }}
                                    </span>
                                    <span class="text-[7px] font-black uppercase mt-1" style="color: #0000FF; opacity: 0.5;">LULUS</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.alumni.hapus', $alumni->id) }}" method="POST" class="form-hapus inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 bg-white rounded-xl border border-slate-100 transition-all active:scale-90 shadow-sm" style="color: #f43f5e;">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-20 text-center text-slate-300 text-[10px] font-black uppercase italic tracking-[0.5em]">
                                Belum ada arsip alumni
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-8 py-3 bg-slate-50 border-t border-slate-100">
            <p class="text-[8px] font-black text-slate-400 uppercase tracking-[0.5em] text-center">Academic Archive System Management</p>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { height: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #0000FF; border-radius: 10px; }
</style>
@endsection