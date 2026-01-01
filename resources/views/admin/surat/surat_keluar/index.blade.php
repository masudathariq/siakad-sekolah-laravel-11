@extends('layouts.admin')

@section('content')
<div class="p-6 bg-slate-50 min-h-screen">
    
    {{-- SATU DIV UTAMA (ALL-IN-ONE CARD) --}}
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
        
        {{-- SECTION 1: HEADER --}}
        <div class="px-8 py-8 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-2 h-10 rounded-full" style="background-color: #0000FF;"></div>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tighter italic uppercase leading-none">
                        Manajemen <span style="color: #0000FF;">Surat Keluar</span>
                    </h1>
                </div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] ml-6 italic">MTs Muhammadiyah 1 Natar</p>
            </div>
            
            <a href="{{ route('admin.surat-keluar.create') }}" 
               class="flex items-center gap-3 px-8 py-4 rounded-2xl transition shadow-lg shadow-blue-200 font-black text-sm uppercase italic tracking-widest active:scale-95"
               style="background-color: #0000FF; color: #FFFFFF;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Surat Keluar
            </a>
        </div>

        {{-- SECTION 2: FILTER & SEARCH --}}
        <div class="px-8 py-7 bg-slate-50/50 border-b border-slate-100">
            <form action="{{ route('admin.surat-keluar.cetak') }}" method="GET" target="_blank" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest italic">Tahun Pelajaran</label>
                    <select name="tahun_ajaran_id" class="w-full border-slate-200 rounded-xl text-xs font-bold focus:ring-[#0000FF] py-2.5 shadow-sm">
                        @foreach($listTahunAjaran as $ta)
                            <option value="{{ $ta->id }}" {{ $ta->aktif ? 'selected' : '' }}>{{ $ta->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest italic">Bulan Surat</label>
                    <select name="bulan" class="w-full border-slate-200 rounded-xl text-xs font-bold focus:ring-[#0000FF] py-2.5 shadow-sm">
                        <option value="">Semua Bulan</option>
                        @for($m=1; $m<=12; $m++)
                            <option value="{{ sprintf('%02d', $m) }}">{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl transition font-black text-xs uppercase italic tracking-widest border border-cyan-200 shadow-sm"
                            style="background-color: #e0faff; color: #0891b2;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        CETAK REKAP PDF
                    </button>
                </div>
                <div class="flex items-end">
                    <div class="relative w-full">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="CARI NOMOR/TUJUAN..." 
                               class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-xs font-bold focus:ring-[#0000FF] uppercase italic tracking-widest placeholder:text-slate-300 shadow-sm">
                        <div class="absolute left-4 top-3.5 text-slate-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- SECTION 3: TABEL --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr style="background-color: #0000FF;">
                        <th class="px-6 py-6 text-xs font-black uppercase tracking-widest text-center" style="color: #FFFFFF;">NO</th>
                        <th class="px-6 py-6 text-xs font-black uppercase tracking-widest border-l border-white/10" style="color: #FFFFFF;">NOMOR & TANGGAL</th>
                        <th class="px-6 py-6 text-xs font-black uppercase tracking-widest border-l border-white/10" style="color: #FFFFFF;">TUJUAN SURAT</th>
                        <th class="px-6 py-6 text-xs font-black uppercase tracking-widest border-l border-white/10" style="color: #FFFFFF;">PERIHAL</th>
                        <th class="px-6 py-6 text-xs font-black uppercase tracking-widest border-l border-white/10 text-center" style="color: #FFFFFF;">SIFAT</th>
                        <th class="px-6 py-6 text-xs font-black uppercase tracking-widest border-l border-white/10 text-center" style="color: #FFFFFF;">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($suratKeluar as $index => $surat)
                        <tr class="hover:bg-blue-50/50 transition-colors group">
                            <td class="px-6 py-6 text-center text-xs font-black text-slate-300 italic group-hover:text-[#0000FF]">
                                {{ $suratKeluar->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-6 leading-tight">
                                <div class="text-sm font-black text-slate-800 uppercase italic">{{ $surat->nomor_surat }}</div>
                                <div class="text-[10px] font-black uppercase mt-1.5 tracking-widest opacity-70" style="color: #0000FF;">
                                    TANGGAL: {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-6 text-[11px] font-black text-slate-600 uppercase italic leading-tight">
                                {{ $surat->tujuan }}
                            </td>
                            <td class="px-6 py-6">
                                <p class="text-[10px] font-bold text-slate-500 uppercase italic line-clamp-2 max-w-[250px] leading-relaxed">
                                    {{ $surat->perihal }}
                                </p>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase italic tracking-tighter"
                                      style="{{ $surat->sifat == 'Penting' ? 'background-color: #fee2e2; color: #ef4444;' : 'background-color: #e0f2fe; color: #0000FF;' }}">
                                    {{ $surat->sifat }}
                                </span>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex items-center justify-center gap-3">
                                    @if($surat->file)
                                        <a href="{{ route('admin.surat-keluar.preview-pdf', $surat->id) }}" target="_blank" 
                                           class="p-2.5 bg-blue-50 text-[#0000FF] rounded-2xl hover:bg-[#0000FF] hover:text-white transition-all shadow-sm border border-blue-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.surat-keluar.edit', $surat->id) }}" 
                                       class="p-2.5 bg-amber-50 text-amber-600 rounded-2xl hover:bg-amber-500 hover:text-white transition-all shadow-sm border border-amber-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <form action="{{ route('admin.surat-keluar.destroy', $surat->id) }}" method="POST" onsubmit="return confirm('Yakin?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-2xl hover:bg-rose-600 hover:text-white transition-all shadow-sm border border-rose-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-24 text-center text-slate-300 text-xs font-black uppercase italic tracking-[0.5em]">Data Surat Keluar Tidak Ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- SECTION 4: FOOTER --}}
        <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
            <div class="flex justify-center">
                {{ $suratKeluar->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .pagination .active span { background-color: #0000FF !important; border-color: #0000FF !important; color: white !important; border-radius: 12px; padding: 8px 16px; }
    .pagination li a, .pagination li span { font-size: 11px; font-weight: 900; color: #0000FF; border-radius: 12px; padding: 8px 16px; border: 1px solid #e2e8f0; }
</style>
@endsection