@extends('layouts.admin')

@section('page-title', 'Tambah Tahun Ajaran')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.tahun-ajaran.index') }}" class="flex items-center text-slate-500 hover:text-indigo-600 transition-colors group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="text-sm font-bold uppercase tracking-wider">Kembali ke Daftar</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <div class="bg-emerald-50/50 border-b border-slate-100 p-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-800">Tambah Tahun Ajaran</h2>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Buat periode akademik baru</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.tahun-ajaran.store') }}" method="POST" class="p-8">
            @csrf

            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">
                        Nama Tahun Ajaran
                    </label>
                    <input type="text" name="nama" 
                           placeholder="Contoh: 2025/2026"
                           required
                           class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-semibold text-slate-700 placeholder:text-slate-300">
                    <div class="mt-3 flex items-start gap-2 ml-1">
                        <svg class="w-3.5 h-3.5 text-amber-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-[10px] text-slate-400 font-medium italic leading-relaxed">Gunakan format "Tahun/Tahun" (seperti 2025/2026) agar laporan nilai dan absensi sinkron.</p>
                    </div>
                </div>

                <div class="bg-emerald-50/30 border border-emerald-100 p-5 rounded-2xl group hover:border-emerald-200 transition-colors">
                    <label class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" name="aktif" value="1" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        </div>
                        <div class="ml-4">
                            <span class="block text-sm font-bold text-slate-700 group-hover:text-emerald-600 transition-colors">Aktifkan Sekarang</span>
                            <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-tight">Tahun ajaran ini akan langsung digunakan secara default</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-slate-100 flex items-center justify-between">
                <p class="text-[10px] font-bold text-slate-300 uppercase hidden sm:block">Lengkapi semua data sebelum menyimpan</p>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <a href="{{ route('admin.tahun-ajaran.index') }}" 
                       class="flex-1 sm:flex-none text-center px-6 py-3 text-xs font-bold text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-widest">
                        Batal
                    </a>
                    <button type="submit" 
                            class="flex-1 sm:flex-none px-8 py-3 bg-emerald-500 text-white text-xs font-bold rounded-2xl shadow-lg shadow-emerald-100 hover:bg-emerald-600 hover:-translate-y-0.5 active:scale-95 transition-all uppercase tracking-widest">
                        Simpan Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection