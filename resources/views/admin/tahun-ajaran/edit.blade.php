@extends('layouts.admin')

@section('page-title', 'Edit Tahun Ajaran')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.tahun-ajaran.index') }}" class="inline-flex items-center text-slate-500 hover:text-indigo-600 transition-all group">
            <div class="w-8 h-8 rounded-full bg-white shadow-sm border border-slate-200 flex items-center justify-center mr-3 group-hover:border-indigo-100 group-hover:bg-indigo-50 transition-all">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </div>
            <span class="text-xs font-black uppercase tracking-[0.2em]">Kembali ke Daftar</span>
        </a>
    </div>

    <div class="bg-white rounded-[2rem] shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden ring-1 ring-black/[0.02]">
        <div class="bg-gradient-to-br from-amber-50/80 to-transparent border-b border-slate-100 p-8 md:p-10">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-amber-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-amber-200 ring-4 ring-amber-50">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">Edit Tahun Ajaran</h2>
                    <p class="text-[10px] font-bold text-amber-600 uppercase tracking-[0.2em] mt-1 flex items-center gap-2">
                        <span class="inline-block w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                        Mode Pembaruan Sistem
                    </p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.tahun-ajaran.update', $tahunAjaran->id) }}" method="POST" class="p-8 md:p-10">
            @csrf
            @method('PUT')

            <div class="space-y-8">
                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1 group-focus-within:text-indigo-600 transition-colors">
                        Nama Tahun Ajaran
                    </label>
                    <div class="relative">
                        <input type="text" name="nama" 
                               value="{{ old('nama', $tahunAjaran->nama) }}" 
                               placeholder="Contoh: 2025/2026"
                               required
                               class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 focus:bg-white transition-all outline-none font-bold text-slate-700 text-lg">
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                    </div>
                    <p class="mt-3 text-[10px] text-slate-400 font-bold ml-1 flex items-center gap-1 uppercase tracking-wider">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Rekomendasi Format: YYYY/YYYY
                    </p>
                </div>

                <div class="relative overflow-hidden p-6 rounded-3xl border-2 transition-all duration-300 {{ $tahunAjaran->aktif ? 'bg-indigo-50/50 border-indigo-100' : 'bg-slate-50 border-slate-100' }}" id="status-container">
                    <label class="flex items-center cursor-pointer group justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center mr-4 shrink-0 transition-transform group-active:scale-90">
                                <svg id="status-icon" class="w-6 h-6 {{ $tahunAjaran->aktif ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <span class="block text-sm font-black text-slate-700 uppercase tracking-tight">Status Aktivasi</span>
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-tighter mt-0.5" id="status-text">
                                    {{ $tahunAjaran->aktif ? 'Tahun Ajaran ini sedang aktif' : 'Tahun Ajaran ini non-aktif' }}
                                </span>
                            </div>
                        </div>

                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="aktif" value="1" 
                                   {{ $tahunAjaran->aktif ? 'checked' : '' }}
                                   onchange="toggleStatusUI(this)"
                                   class="sr-only peer">
                            <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-6 after:transition-all peer-checked:bg-indigo-600 shadow-inner"></div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-4">
                <a href="{{ route('admin.tahun-ajaran.index') }}" 
                   class="w-full sm:w-auto text-center px-8 py-4 text-xs font-black text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-[0.2em]">
                    Batalkan
                </a>
                <button type="submit" 
                        class="w-full sm:w-auto px-12 py-4 bg-indigo-600 text-white text-xs font-black rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 active:scale-95 transition-all uppercase tracking-[0.2em] flex items-center justify-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                    Perbarui Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleStatusUI(checkbox) {
        const container = document.getElementById('status-container');
        const icon = document.getElementById('status-icon');
        const text = document.getElementById('status-text');

        if (checkbox.checked) {
            container.classList.remove('bg-slate-50', 'border-slate-100');
            container.classList.add('bg-indigo-50/50', 'border-indigo-100');
            icon.classList.remove('text-slate-400');
            icon.classList.add('text-indigo-600');
            text.textContent = 'Tahun Ajaran ini sedang aktif';
        } else {
            container.classList.remove('bg-indigo-50/50', 'border-indigo-100');
            container.classList.add('bg-slate-50', 'border-slate-100');
            icon.classList.remove('text-indigo-600');
            icon.classList.add('text-slate-400');
            text.textContent = 'Tahun Ajaran ini non-aktif';
        }
    }
</script>
@endsection