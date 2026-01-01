@extends('layouts.admin')

@section('page-title', 'Edit Rombongan Belajar')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.rombel.index', ['tahun_ajaran' => $rombel->tahun_ajaran_id]) }}" 
           class="flex items-center text-slate-500 hover:text-indigo-600 transition-colors group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="text-sm font-bold uppercase tracking-wider">Kembali ke Daftar Rombel</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <div class="bg-indigo-50/50 border-b border-slate-100 p-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-800 uppercase tracking-tight">Edit Rombel</h2>
                        <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mt-1">
                            Periode: {{ $rombel->tahunAjaran->nama ?? 'Tahun Ajaran Aktif' }}
                        </p>
                    </div>
                </div>
                <div class="hidden sm:block text-right">
                    <span class="px-3 py-1 bg-white border border-indigo-100 text-indigo-600 text-[10px] font-bold rounded-full uppercase tracking-tighter">
                        ID Rombel: #{{ $rombel->id }}
                    </span>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.rombel.update', $rombel->id) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- TINGKAT --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Tingkat / Kelas Utama</label>
                    <select name="tingkat_id" required 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700 appearance-none">
                        @foreach($tingkats as $tingkat)
                            <option value="{{ $tingkat->id }}" {{ old('tingkat_id', $rombel->tingkat_id) == $tingkat->id ? 'selected' : '' }}>
                                Tingkat {{ $tingkat->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- JENIS ROMBEL --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Kategori Program</label>
                    <select name="jenis_rombel" required 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700 appearance-none">
                        <option value="reguler" {{ old('jenis_rombel', $rombel->jenis_rombel) == 'reguler' ? 'selected' : '' }}>Reguler (Umum)</option>
                        <option value="pondok" {{ old('jenis_rombel', $rombel->jenis_rombel) == 'pondok' ? 'selected' : '' }}>Pondok (Tahfidz)</option>
                    </select>
                </div>

                {{-- KODE KELAS --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Kode / Nama Singkat</label>
                    <input type="text" name="kode_kelas" value="{{ old('kode_kelas', $rombel->kode_kelas) }}" required
                           placeholder="Misal: A atau VIII-A"
                           class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700">
                </div>

                {{-- NAMA KELAS --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Nama Identitas (Optional)</label>
                    <input type="text" name="nama_kelas" value="{{ old('nama_kelas', $rombel->nama_kelas) }}"
                           placeholder="Misal: Al-Khawarizmi"
                           class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700">
                </div>

                {{-- WALI KELAS --}}
                <div class="md:col-span-2 space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Guru Wali Kelas</label>
                    <div class="relative">
                        <select name="wali_kelas_id" 
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700 appearance-none">
                            <option value="">-- Belum Ada Wali Kelas --</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}" {{ old('wali_kelas_id', $rombel->wali_kelas_id) == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->nama }} ({{ $guru->nuptk ?? 'Guru' }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-4">
                <a href="{{ route('admin.rombel.index', ['tahun_ajaran' => $rombel->tahun_ajaran_id]) }}" 
                   class="w-full sm:w-auto text-center px-8 py-4 text-xs font-bold text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-[0.2em]">
                    Batalkan
                </a>
                <button type="submit" 
                        class="w-full sm:w-auto px-10 py-4 bg-indigo-600 text-white text-xs font-bold rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 active:scale-95 transition-all uppercase tracking-[0.2em]">
                    Update Rombel
                </button>
            </div>
        </form>
    </div>

    <div class="mt-8 px-4 flex items-center gap-3 justify-center">
        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Perubahan data rombel akan langsung berpengaruh pada absensi dan nilai seluruh siswa di kelas ini.</p>
    </div>
</div>
@endsection