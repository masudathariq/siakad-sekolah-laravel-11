@extends('layouts.admin')

@section('page-title', 'Cetak Daftar Hadir Siswa')

@section('content')
<div class="py-8">
    <div class="max-w-xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            
            <div class="bg-gradient-to-r from-blue-700 to-blue-500 p-6 text-white">
                <div class="flex items-center justify-center space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <h1 class="text-xl font-semibold tracking-wide">Cetak Daftar Hadir</h1>
                </div>
                <p class="text-blue-100 text-center text-sm mt-1 opacity-90">Atur format cetakan daftar hadir siswa</p>
            </div>

            <form action="{{ route('admin.cetak_daftarhadir_siswa') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="rombel_id" class="text-sm font-medium text-slate-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Pilih Rombongan Belajar
                    </label>
                    <select name="rombel_id" id="rombel_id" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none appearance-none cursor-pointer text-slate-600">
                        <option value="">-- Pilih Rombel --</option>
                        @foreach($rombels as $r)
                            <option value="{{ $r->id }}">{{ $r->nama_kelas }} ({{ $r->tingkat->nama }})</option>
                        @endforeach
                    </select>
                    @error('rombel_id')
                        <p class="text-red-500 text-xs mt-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="judul_atas" class="text-sm font-medium text-slate-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Judul Atas Laporan
                    </label>
                    <input type="text" name="judul_atas" id="judul_atas" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none text-slate-600" 
                        value="Daftar Hadir Siswa">
                    @error('judul_atas')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="judul_bawah" class="text-sm font-medium text-slate-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Judul Bawah Laporan
                    </label>
                    <input type="text" name="judul_bawah" id="judul_bawah" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none text-slate-600" 
                        placeholder="Contoh : Pengambilan Raport">
                    @error('judul_bawah')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

<!-- Tombol submit -->
<div class="pt-2">
    <button id="btnSubmit" type="submit"
        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-3 rounded-xl shadow-md hover:shadow-lg hover:from-blue-700 hover:to-blue-800 transition-all transform hover:-translate-y-0.5 active:scale-95 flex items-center justify-center space-x-2">
        
        <!-- Spinner hidden default -->
        <svg id="spinner" class="h-5 w-5 animate-spin hidden text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>

        <span>Cetak Dokumen PDF</span>
    </button>
</div>
            </form>

            <div class="bg-slate-50 p-4 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-400 italic">Pastikan data rombel sudah sesuai sebelum mencetak.</p>
            </div>
        </div>
    </div>
</div>
@endsection