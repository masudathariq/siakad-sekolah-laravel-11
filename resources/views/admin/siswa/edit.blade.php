@extends('layouts.admin')

@section('title', 'Edit Data Siswa')

@section('content')
    <div class="max-w-3xl mx-auto"> {{-- Max width dipersempit dari 4xl ke 3xl --}}
        
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-slate-900 rounded-xl shadow-lg flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-800 tracking-tight">Edit Siswa</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Update Data Master</p>
                </div>
            </div>
            <a href="{{ route('admin.siswa.index') }}" 
               class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-[10px] font-black text-slate-500 uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm">
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-[2rem] shadow-[0_20px_50px_-12px_rgba(0,0,0,0.12)] border border-slate-200 overflow-hidden">
            
            <div class="h-1.5 bg-gradient-to-r from-indigo-600 to-violet-600"></div>

            <form action="{{ route('admin.siswa.update', $siswa->nisn) }}" method="POST" class="p-6 md:p-8">
                @csrf
                @method('PUT')

                <div class="space-y-8">
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-1.5 h-4 bg-indigo-600 rounded-full"></span>
                            <h4 class="text-[11px] font-black text-slate-800 uppercase tracking-[0.2em]">Profil Utama</h4>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">NISN (Kunci)</label>
                                <input type="text" value="{{ $siswa->nisn }}" readonly
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-400 cursor-not-allowed text-sm">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider ml-1">Nomor Induk Siswa</label>
                                <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" required
                                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/5 transition-all outline-none font-semibold text-slate-700 text-sm shadow-sm">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider ml-1">Nama Lengkap</label>
                            <input type="text" name="nama_siswa" value="{{ old('nama_siswa', $siswa->nama_siswa) }}" required
                                   class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/5 transition-all outline-none font-semibold text-slate-700 text-sm shadow-sm">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider ml-1">Gender</label>
                                <select name="jenis_kelamin" required
                                        class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700 text-sm shadow-sm cursor-pointer">
                                    <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin)=='L'?'selected':'' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin)=='P'?'selected':'' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider ml-1">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" required
                                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700 text-sm">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider ml-1">Tgl Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d')) }}" required
                                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700 text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-1.5 h-4 bg-amber-500 rounded-full"></span>
                            <h4 class="text-[11px] font-black text-slate-800 uppercase tracking-[0.2em]">Keluarga & Domisili</h4>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider ml-1">Nama Ayah</label>
                                <input type="text" name="ayah" value="{{ old('ayah', $siswa->ayah) }}"
                                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700 text-sm">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider ml-1">Nama Ibu</label>
                                <input type="text" name="ibu" value="{{ old('ibu', $siswa->ibu) }}"
                                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700 text-sm">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider ml-1">Nama Wali</label>
                                <input type="text" name="wali" value="{{ old('wali', $siswa->wali) }}"
                                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700 text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider ml-1">Alamat Domisili</label>
                                <input type="text" name="alamat" value="{{ old('alamat', $siswa->alamat) }}"
                                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700 text-sm">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider ml-1">Sekolah Asal</label>
                                <input type="text" name="sekolah_asal" value="{{ old('sekolah_asal', $siswa->sekolah_asal) }}"
                                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 transition-all outline-none font-semibold text-slate-700 text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="submit" 
                                class="px-8 py-3 bg-indigo-600 text-white text-[11px] font-black rounded-xl uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 active:scale-95">
                            Update Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection