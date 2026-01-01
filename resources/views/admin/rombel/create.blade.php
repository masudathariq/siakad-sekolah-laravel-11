@extends('layouts.admin')

@section('page-title', 'Tambah Rombongan Belajar')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.rombel.index', ['tahun_ajaran' => $tahunAjaran->id]) }}" 
           class="flex items-center text-slate-500 hover:text-emerald-600 transition-colors group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="text-sm font-bold uppercase tracking-wider">Kembali ke Daftar</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <div class="bg-emerald-50/50 border-b border-slate-100 p-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-800 uppercase tracking-tight">Tambah Rombel</h2>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">
                                Untuk Tahun Ajaran: {{ $tahunAjaran->nama }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.rombel.store') }}" method="POST" class="p-8">
            @csrf
            
            {{-- TAHUN AJARAN TERKUNCI --}}
            <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaran->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- TINGKAT --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Pilih Tingkat</label>
                    <select name="tingkat_id" required 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-semibold text-slate-700">
                        <option value="">-- Pilih Tingkat --</option>
                        @foreach($tingkats as $tingkat)
                            <option value="{{ $tingkat->id }}" {{ old('tingkat_id') == $tingkat->id ? 'selected' : '' }}>
                                Tingkat {{ $tingkat->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- JENIS ROMBEL --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Kategori Program</label>
                    <select name="jenis_rombel" required 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-semibold text-slate-700">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="reguler" {{ old('jenis_rombel') == 'reguler' ? 'selected' : '' }}>Reguler (Umum)</option>
                        <option value="pondok" {{ old('jenis_rombel') == 'pondok' ? 'selected' : '' }}>Pondok (Tahfidz)</option>
                    </select>
                </div>

                {{-- KODE KELAS --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Kode Kelas</label>
                    <input type="text" name="kode_kelas" value="{{ old('kode_kelas') }}" required
                           placeholder="Contoh: A atau VII-A"
                           class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-semibold text-slate-700">
                </div>

                {{-- NAMA KELAS --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Nama Identitas (Opsional)</label>
                    <input type="text" name="nama_kelas" value="{{ old('nama_kelas') }}"
                           placeholder="Contoh: Al-Mu'min"
                           class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-semibold text-slate-700">
                </div>

                {{-- WALI KELAS --}}
                <div class="md:col-span-2 space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Tentukan Wali Kelas</label>
                    <select name="wali_kelas_id" 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-semibold text-slate-700">
                        <option value="">-- Pilih Wali Kelas --</option>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}" {{ old('wali_kelas_id') == $guru->id ? 'selected' : '' }}>
                                {{ $guru->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-10 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-4">
                <a href="{{ route('admin.rombel.index', ['tahun_ajaran' => $tahunAjaran->id]) }}" 
                   class="w-full sm:w-auto text-center px-8 py-4 text-xs font-bold text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-[0.2em]">
                    Batal
                </a>
                <button type="submit" 
                        class="w-full sm:w-auto px-10 py-4 bg-emerald-500 text-white text-xs font-bold rounded-2xl shadow-xl shadow-emerald-100 hover:bg-emerald-600 hover:-translate-y-1 active:scale-95 transition-all uppercase tracking-[0.2em]">
                    Simpan Rombel
                </button>
            </div>
        </form>
    </div>

    <div class="mt-6 p-4 bg-amber-50 rounded-2xl border border-amber-100 flex items-start gap-3">
        <svg class="w-5 h-5 text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-[11px] text-amber-700 font-medium leading-relaxed uppercase">
            <strong>Perhatian:</strong> Rombel yang Anda buat akan langsung terikat pada Tahun Ajaran <strong>{{ $tahunAjaran->nama }}</strong>. Pastikan data sudah benar sebelum menyimpan.
        </p>
    </div>
</div>
@endsection