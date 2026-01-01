@extends('layouts.admin')

@section('content')
<div class="space-y-4 animate-in fade-in duration-500 pb-10">
    
    {{-- BARIS ATAS: HEADER & ACTIONS --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
        {{-- Header Box --}}
        <div class="lg:col-span-8 bg-white rounded-[2.5rem] p-6 shadow-sm border border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-700 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-black text-slate-800 tracking-tighter uppercase italic leading-none">
                        Database <span class="text-blue-600 font-black">Siswa</span>
                    </h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic">MTs Muhammadiyah 1 Natar</p>
                </div>
            </div>
            
            <div class="flex gap-2">
                <a href="{{ route('admin.siswa.template') }}" class="p-3 bg-slate-200 text-slate-700 rounded-2xl hover:bg-red-500 hover:text-slate-600 transition-all border border-slate-100" title="Download Template Excel">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </a>
                <a href="{{ route('admin.siswa.create') }}" class="flex items-center gap-2 px-6 py-3 bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-2xl hover:shadow-lg hover:shadow-blue-200 transition-all active:scale-95 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="text-[11px] font-black uppercase italic tracking-widest">Tambah Siswa</span>
                </a>
            </div>
        </div>

        {{-- Import Box --}}
        <div class="lg:col-span-4 bg-white rounded-[2.5rem] p-4 shadow-sm border border-slate-100 flex items-center">
            <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data" id="form-import" class="w-full">
                @csrf
                <input type="file" name="file" id="import-file" class="hidden" accept=".xlsx,.xls,.csv" onchange="handleImport(this)">
                <label for="import-file" class="flex items-center justify-between w-full p-2 bg-emerald-50/50 rounded-2xl border border-emerald-100 cursor-pointer hover:bg-emerald-50 transition-colors group">
                    <div class="flex items-center gap-3 ml-2">
                        <div class="w-8 h-8 bg-emerald-500 rounded-xl flex items-center justify-center text-white shadow-sm group-hover:rotate-12 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span id="label-text-import" class="text-[11px] font-black text-emerald-700 uppercase italic tracking-tight">Import Excel</span>
                    </div>
                    <div class="bg-white px-3 py-1.5 rounded-xl shadow-sm border border-emerald-100 text-[9px] font-black text-emerald-600 uppercase">Pilih File</div>
                </label>
            </form>
        </div>
    </div>

    {{-- BARIS TENGAH: FILTERS --}}
    <div class="bg-white rounded-[2rem] p-3 shadow-sm border border-slate-400 flex flex-wrap gap-3">
        <div class="relative flex-1 min-w-[300px]">
            <input type="text" id="search-input" placeholder="CARI NISN / NAMA SISWA..." 
                   class="w-full pl-12 pr-4 py-3 bg-slate-200 border-none rounded-2xl text-[12px] font-bold focus:ring-2 focus:ring-blue-600 uppercase italic transition-all">
            <div class="absolute left-4 top-3.5 text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
        
        <select id="jk-filter" class="px-6 py-3 bg-slate-200 border-none rounded-2xl text-[11px] font-black uppercase italic focus:ring-2 focus:ring-blue-600 appearance-none cursor-pointer pr-10">
            <option value="">GENDER (SEMUA)</option>
            <option value="L">LAKI-LAKI (L)</option>
            <option value="P">PEREMPUAN (P)</option>
        </select>

        <form action="{{ route('admin.siswa.hapusSemua') }}" method="POST" class="form-hapus-semua">
            @csrf @method('DELETE')
            <button type="submit" class="h-full px-6 py-3 bg-rose-50 text-rose-600 rounded-2xl hover:bg-rose-600 hover:text-white transition-all flex items-center gap-2 group border border-rose-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2.227 2.227 0 0116.138 21H7.862a2.227 2.227 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <span class="text-[11px] font-black uppercase italic tracking-wider">Reset Data</span>
            </button>
        </form>
    </div>

    {{-- SECTION 3: DATA TABLE --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="siswa-table">
                <thead>
                    <tr class="bg-blue-600 border-b border-blue-700">
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-white italic">Identitas Siswa</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-white italic border-l border-blue-500/30">Akademik</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-white italic border-l border-blue-500/30 text-center">Gender</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-white italic border-l border-blue-500/30">Kelahiran</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-white italic border-l border-blue-500/30 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="table-body" class="divide-y divide-slate-50 bg-white">
                    @forelse($siswa as $s)
                        <tr class="hover:bg-blue-50/40 transition-all group relative">
                            <td class="px-8 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="absolute left-0 w-1 h-10 bg-gradient-to-b from-blue-600 to-blue-400 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <div class="flex flex-col">
                                        <span class="text-[13px] font-black text-slate-800 uppercase italic tracking-tight">{{ $s->nama_siswa }}</span>
                                        <div class="flex gap-2 mt-0.5">
                                            <span class="text-[10px] font-bold text-blue-500 uppercase tracking-tighter">NISN: {{ $s->nisn }}</span>
                                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter border-l border-slate-200 pl-2">NIS: {{ $s->nis }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-[11px] font-black text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg w-max uppercase italic">
                                        {{ $s->rombel->nama_kelas ?? 'Tanpa Rombel' }}
                                    </span>
                                    <span class="text-[9px] text-slate-600 font-bold uppercase tracking-tighter mt-1 ml-1">
                                        {{ $s->rombel->tingkat->nama ?? 'Tingkat' }} - {{ $s->rombel->kode_kelas ?? 'N/A' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl text-[11px] font-black uppercase {{ $s->jenis_kelamin == 'L' ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                                    {{ $s->jenis_kelamin }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-[11px] font-black text-slate-600 uppercase italic leading-none">{{ $s->tempat_lahir }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase italic mt-1">
    {{ \Carbon\Carbon::parse($s->tanggal_lahir)->translatedFormat('d F Y') }}
</span>

                                </div>
                            </td>
                            <td class="px-8 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.siswa.show', $s->nisn) }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-slate-800 hover:text-white transition-all border border-slate-100 shadow-sm" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </a>
                                    <a href="{{ route('admin.siswa.edit', $s->nisn) }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all border border-blue-100 shadow-sm shadow-blue-50" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <form action="{{ route('admin.siswa.destroy', $s->nisn) }}" method="POST" class="form-hapus inline">
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
                            <td colspan="5" class="py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2.5rem] flex items-center justify-center text-slate-200 mb-5 border border-slate-100 shadow-inner">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                    </div>
                                    <h3 class="text-[13px] font-black text-slate-400 uppercase italic tracking-[0.2em]">Data Tidak Ditemukan</h3>
                                    <p class="text-[10px] text-slate-300 font-bold uppercase mt-2">Coba sesuaikan filter atau kata kunci pencarian Anda</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-8 py-8 bg-slate-50/50 border-t border-slate-100">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <span class="text-[10px] font-black text-slate-400 uppercase italic tracking-widest">
                    Showing {{ $siswa->firstItem() ?? 0 }} to {{ $siswa->lastItem() ?? 0 }} of {{ $siswa->total() }} results
                </span>
                <div class="scale-95 transform">
                    {{ $siswa->appends(request()->input())->links('vendor.pagination.custom-tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const swalConfig = {
        customClass: {
            popup: 'rounded-[3rem] p-10 border-8 border-white shadow-2xl',
            confirmButton: 'rounded-2xl px-8 py-4 font-black uppercase italic text-[11px] tracking-widest mx-2 shadow-lg transition-transform active:scale-95',
            cancelButton: 'rounded-2xl px-8 py-4 font-black uppercase italic text-[11px] tracking-widest mx-2 bg-slate-100 text-slate-500 shadow-sm transition-transform active:scale-95'
        },
        buttonsStyling: false
    };

    function handleImport(input) {
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            document.getElementById('label-text-import').textContent = fileName;
            
            Swal.fire({
                ...swalConfig,
                title: '<span class="text-2xl font-black uppercase italic tracking-tighter">Konfirmasi Import</span>',
                html: `<div class="bg-blue-50 p-4 rounded-2xl border border-blue-100 mt-4"><p class="text-[11px] font-bold text-blue-700 uppercase tracking-widest leading-relaxed">System akan memproses berkas:<br><span class="text-blue-900 break-all">${fileName}</span></p></div>`,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'YA, IMPORT SEKARANG',
                cancelButtonText: 'BATALKAN',
                confirmButtonClass: swalConfig.customClass.confirmButton + ' bg-blue-600 text-white',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'MEMPROSES DATA...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
                    document.getElementById('form-import').submit();
                } else {
                    input.value = ''; 
                    document.getElementById('label-text-import').textContent = "Import Excel";
                }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const jkFilter = document.getElementById('jk-filter');
        const tableBody = document.getElementById('table-body');

        function fetchSiswa() {
            const q = searchInput.value;
            const jk = jkFilter.value;
            fetch(`{{ route('admin.siswa.index') }}?q=${q}&jk=${jk}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTbody = doc.getElementById('table-body');
                if(newTbody) {
                    tableBody.innerHTML = newTbody.innerHTML;
                    initDeleteButtons();
                }
            });
        }

        let debounceTimer;
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(fetchSiswa, 300);
        });
        jkFilter.addEventListener('change', fetchSiswa);

        function initDeleteButtons() {
            document.querySelectorAll('.form-hapus').forEach(form => {
                form.onsubmit = function(e) {
                    e.preventDefault();
                    Swal.fire({
                        ...swalConfig,
                        title: '<span class="text-2xl font-black uppercase italic tracking-tighter text-rose-600">Hapus Data?</span>',
                        text: "Data yang dihapus tidak dapat dipulihkan kembali dari server!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'YA, HAPUS PERMANEN',
                        cancelButtonText: 'KEMBALI',
                        confirmButtonClass: swalConfig.customClass.confirmButton + ' bg-rose-600 text-white',
                    }).then((result) => { if(result.isConfirmed) form.submit(); });
                };
            });
        }
        initDeleteButtons();

        const hapusSemuaForm = document.querySelector('.form-hapus-semua');
        if(hapusSemuaForm) {
            hapusSemuaForm.onsubmit = function(e){
                e.preventDefault();
                Swal.fire({
                    ...swalConfig,
                    title: '<span class="text-2xl font-black uppercase italic text-rose-600 tracking-tighter">RESET DATABASE?</span>',
                    html: '<div class="bg-rose-50 p-4 rounded-2xl border border-rose-100 mt-4"><p class="text-[11px] font-bold text-rose-700 uppercase tracking-widest leading-relaxed">Seluruh data siswa akan dihapus secara total dari sistem!</p></div>',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonText: 'YA, KOSONGKAN SEKARANG',
                    cancelButtonText: 'BATALKAN',
                    confirmButtonClass: swalConfig.customClass.confirmButton + ' bg-rose-600 text-white',
                }).then((result) => { if(result.isConfirmed) hapusSemuaForm.submit(); });
            };
        }
    });
</script>

@if(session('success'))
<script>
    Swal.fire({ 
        ...swalConfig,
        icon: 'success', 
        title: '<span class="text-emerald-600 tracking-tighter">BERHASIL!</span>', 
        html: '<span class="text-[11px] font-bold uppercase tracking-widest text-slate-500">{{ session('success') }}</span>', 
        timer: 2500, 
        showConfirmButton: false
    });
</script>
@endif
@endsection