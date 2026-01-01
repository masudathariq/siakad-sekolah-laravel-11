@extends('layouts.admin')

@section('page-title', 'Data Guru')

@section('content')
<div class="space-y-4 animate-in fade-in duration-500 pb-10">
    
    {{-- SECTION 1: HEADER & ACTIONS --}}
    <div class="bg-white rounded-[2.5rem] p-6 shadow-sm border border-slate-100 flex flex-col lg:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-gradient-to-br from-blue-700 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">
                    Data <span class="text-blue-600">Tenaga Pengajar</span>
                </h1>
                <p class="text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] mt-1 italic">MTs Muhammadiyah 1 Natar</p>
            </div>
        </div>
        
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('admin.guru.cetak') }}" target="_blank" class="px-6 py-3 bg-white text-slate-700 rounded-2xl hover:bg-slate-900 hover:text-white transition-all border border-slate-200 flex items-center gap-2 group shadow-sm font-black text-[10px] uppercase italic tracking-widest">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak
            </a>
            
            <a href="{{ route('admin.guru.cetak_daftarhadir.form') }}" class="px-6 py-3 bg-white text-slate-700 rounded-2xl hover:bg-slate-900 hover:text-white transition-all border border-slate-200 flex items-center gap-2 shadow-sm font-black text-[10px] uppercase italic tracking-widest">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                Cetak Absensi
            </a>

            <a href="{{ route('admin.guru.create') }}" class="flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-700 to-blue-500 text-white rounded-2xl hover:shadow-xl hover:shadow-blue-200 transition-all active:scale-95 shadow-md font-black text-[11px] uppercase italic tracking-widest">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                Tambah Guru Baru
            </a>
        </div>
    </div>

    {{-- SECTION 2: SEARCH & STATS --}}
    <div class="bg-white rounded-[2rem] p-3 shadow-sm border border-slate-100 flex flex-wrap gap-4 items-center">
        <div class="relative flex-1 min-w-[300px]">
            <input type="text" id="searchInput" placeholder="CARI NAMA PENGAJAR..." 
                   class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-2xl text-[13px] font-bold focus:ring-2 focus:ring-blue-600 uppercase italic transition-all text-slate-800 placeholder:text-slate-400">
            <div class="absolute left-4 top-3.5 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
        
        <div class="px-8 py-3 bg-blue-600 rounded-2xl flex items-center gap-3 shadow-md shadow-blue-100">
            <span class="text-[12px] font-black text-white uppercase italic tracking-widest">
                TOTAL: {{ $guru->count() }} GURU
            </span>
        </div>
    </div>

    {{-- SECTION 3: TABEL --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    {{-- Header Biru Kontras Tinggi --}}
                    <tr class="bg-blue-600 border-b border-blue-700">
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-white italic text-center w-24">ID</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-white italic border-l border-white/10">Nama Lengkap</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-white italic border-l border-white/10 text-center">Gender</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-white italic border-l border-white/10 text-center">Masa Kerja</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-white italic border-l border-white/10 text-center">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-white italic border-l border-white/10 text-center">Opsi Aksi</th>
                    </tr>
                </thead>
                <tbody id="guruTable" class="divide-y divide-slate-50 bg-white">
                    @forelse($guru as $g)
                        <tr class="hover:bg-blue-50/40 transition-all group relative border-b border-slate-50">
                            <td class="px-8 py-5 text-center">
                                <span class="text-xs font-black text-slate-700 italic group-hover:text-blue-700 transition-colors">#{{ $g->id_guru }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="text-[13px] font-black text-slate-800 uppercase italic tracking-tight group-hover:text-blue-700 transition-colors">{{ $g->nama }}</span>
                                    <span class="text-[9px] font-black text-slate-600 uppercase tracking-tighter mt-0.5">NUPTK: {{ $g->nuptk ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-xl text-[10px] font-black uppercase {{ $g->jenis_kelamin == 'L' ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                                    {{ $g->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-[11px] font-black text-slate-700 bg-slate-100 px-3 py-1 rounded-lg uppercase italic border border-slate-200">
                                    {{ $g->masa_kerja }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <form action="{{ route('admin.guru.status', $g->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="px-5 py-2 rounded-xl text-[9px] font-black uppercase italic tracking-widest transition-all border shadow-sm active:scale-95 text-white"
                                        style="{{ $g->status ? 'background-color: #059669; border-color: #059669;' : 'background-color: #dc2626; border-color: #dc2626;' }}">
                                        {{ $g->status ? 'Aktif' : 'Non-Aktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.guru.show', $g->id) }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-slate-800 hover:text-white transition-all border border-slate-100 shadow-sm" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </a>
                                    <a href="{{ route('admin.guru.edit', $g->id) }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all border border-blue-100 shadow-sm shadow-blue-50" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <form action="{{ route('admin.guru.destroy', $g->id) }}" method="POST" onsubmit="return hapusGuru(this)" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-600 hover:text-white transition-all border border-rose-100 shadow-sm shadow-rose-50" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2.227 2.227 0 0116.138 21H7.862a2.227 2.227 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-32 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2.5rem] flex items-center justify-center text-slate-200 mb-5 border border-slate-100 shadow-inner">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    </div>
                                    <h3 class="text-[13px] font-black text-slate-400 uppercase italic tracking-[0.2em]">Belum Ada Data Pengajar</h3>
                                    <p class="text-[10px] text-slate-300 font-bold uppercase mt-2">Klik tombol 'Tambah Guru Baru' untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const swalConfig = {
    customClass: {
        popup: 'rounded-[3rem] p-10 border-8 border-white shadow-2xl',
        confirmButton: 'rounded-2xl px-8 py-4 font-black uppercase italic text-[11px] tracking-widest mx-2 shadow-lg transition-transform active:scale-95 bg-blue-600 text-white',
        cancelButton: 'rounded-2xl px-8 py-4 font-black uppercase italic text-[11px] tracking-widest mx-2 bg-slate-100 text-slate-600 shadow-sm transition-transform active:scale-95'
    },
    buttonsStyling: false
};

document.getElementById('searchInput').addEventListener('input', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#guruTable tr');
    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});

function hapusGuru(form) {
    event.preventDefault();
    Swal.fire({
        ...swalConfig,
        title: '<span class="text-2xl font-black uppercase italic tracking-tighter text-rose-600">Hapus Data Guru?</span>',
        html: '<div class="bg-rose-50 p-4 rounded-2xl border border-rose-100 mt-4"><p class="text-[11px] font-black text-rose-700 uppercase tracking-widest leading-relaxed text-center">Seluruh riwayat pengajar ini akan dihapus permanen dari sistem!</p></div>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'YA, HAPUS PERMANEN',
        cancelButtonText: 'BATALKAN',
    }).then((result) => { if (result.isConfirmed) form.submit(); });
}
</script>
@endsection