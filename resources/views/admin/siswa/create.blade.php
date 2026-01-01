@extends('layouts.admin')

@section('page-title', 'Tambah Data Siswa')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.siswa.index') }}" class="flex items-center text-slate-500 hover:text-indigo-600 transition-colors group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="text-sm font-bold uppercase tracking-wider">Kembali ke Daftar Siswa</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <div class="bg-indigo-600 p-8 md:p-10">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-white/20 backdrop-blur-md text-white rounded-2xl flex items-center justify-center shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-white tracking-tight">Registrasi Siswa Baru</h2>
                    <p class="text-indigo-100 text-xs font-bold uppercase tracking-[0.2em] mt-1 opacity-80">Lengkapi formulir biodata peserta didik</p>
                </div>
            </div>
        </div>

        @if ($errors->any())
        <div class="mx-8 mt-8 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-2xl flex gap-3 items-start">
            <svg class="w-5 h-5 text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
            <div>
                <p class="text-xs font-black text-red-800 uppercase tracking-wider">Mohon Perbaiki Kesalahan Berikut:</p>
                <ul class="mt-1 list-disc list-inside text-xs text-red-700 font-medium leading-relaxed">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <form action="{{ route('admin.siswa.store') }}" method="POST" class="p-8 md:p-10">
            @csrf

            <div class="space-y-12">
                <div class="relative">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-xs font-black">01</span>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest border-b-2 border-indigo-500 pb-1">Identitas Peserta Didik</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nomor NISN</label>
                            <input type="text" name="nisn" value="{{ old('nisn') }}" required placeholder="Contoh: 0012345678"
                                   class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nomor NIS (Sekolah)</label>
                            <input type="text" name="nis" value="{{ old('nis') }}" required placeholder="Contoh: 2023001"
                                   class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700">
                        </div>
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap Siswa</label>
                            <input type="text" name="nama_siswa" value="{{ old('nama_siswa') }}" required placeholder="Masukkan nama sesuai ijazah/akta"
                                   class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" required 
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700">
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ old('jenis_kelamin')=='L'?'selected':'' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin')=='P'?'selected':'' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required placeholder="Kota"
                                       class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tgl Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                       class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700">
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-8 h-8 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-xs font-black">02</span>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest border-b-2 border-amber-500 pb-1">Data Orang Tua / Wali</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Ayah</label>
                            <input type="text" name="ayah" value="{{ old('ayah') }}" placeholder="Nama Lengkap"
                                   class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all outline-none font-semibold text-slate-700">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Ibu</label>
                            <input type="text" name="ibu" value="{{ old('ibu') }}" placeholder="Nama Lengkap"
                                   class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all outline-none font-semibold text-slate-700">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Wali</label>
                            <input type="text" name="wali" value="{{ old('wali') }}" placeholder="Jika Ada"
                                   class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all outline-none font-semibold text-slate-700">
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs font-black">03</span>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest border-b-2 border-emerald-500 pb-1">Domisili & Pendidikan</h3>
                    </div>
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" placeholder="Jl. Nama Jalan, No. Rumah, RT/RW, Kec, Kab"
                                      class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-semibold text-slate-700">{{ old('alamat') }}</textarea>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Sekolah Asal</label>
                            <input type="text" name="sekolah_asal" value="{{ old('sekolah_asal') }}" placeholder="Nama SD/MI Sebelumnya"
                                   class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-semibold text-slate-700">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-16 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pastikan data sudah diperiksa kembali</p>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <a href="{{ route('admin.siswa.index') }}" 
                       class="flex-1 sm:flex-none text-center px-10 py-4 text-xs font-black text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-widest">
                        Batal
                    </a>
                    <button type="submit" 
                            class="flex-1 sm:flex-none px-12 py-4 bg-indigo-600 text-white text-xs font-black rounded-2xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 active:scale-95 transition-all uppercase tracking-widest">
                        Simpan Data Siswa
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection