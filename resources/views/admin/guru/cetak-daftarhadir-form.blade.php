@extends('layouts.admin')

@section('page-title', 'Cetak Daftar Hadir')

@section('content')
<div class="py-10 px-4">
    <div class="max-w-xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
            
            <div class="bg-gradient-to-br from-blue-700 to-blue-500 p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-4 backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-extrabold uppercase tracking-wider text-white">
                    Konfigurasi Cetak
                </h2>
                <p class="text-blue-100 text-sm mt-2">Atur informasi kepala laporan sebelum mengunduh</p>
            </div>

            <form action="{{ route('admin.guru.cetak_daftarhadir') }}"
                  method="POST"
                  target="_blank"
                  class="p-8">
                @csrf

                <div class="space-y-6">
                    {{-- JUDUL ATAS --}}
                    <div class="group">
                        <label class="block text-xs font-bold uppercase mb-2 text-slate-500 group-focus-within:text-blue-600 transition-colors">
                            Judul Atas Laporan
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                </svg>
                            </span>
                            <input type="text"
                                   name="judul_atas"
                                   placeholder="Contoh: DAFTAR HADIR GURU"
                                   class="w-full border border-slate-200 pl-10 pr-4 py-3 rounded-xl text-sm focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all outline-none bg-slate-50 focus:bg-white"
                                   required>
                        </div>
                    </div>

                    {{-- JUDUL BAWAH --}}
                    <div class="group">
                        <label class="block text-xs font-bold uppercase mb-2 text-slate-500 group-focus-within:text-blue-600 transition-colors">
                            Judul Bawah Laporan
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </span>
                            <input type="text"
                                   name="judul_bawah"
                                   placeholder="Contoh: Rapat Supervisi Semester Ganjil"
                                   class="w-full border border-slate-200 pl-10 pr-4 py-3 rounded-xl text-sm focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all outline-none bg-slate-50 focus:bg-white"
                                   required>
                        </div>
                    </div>
                </div>

                {{-- ACTION BUTTON --}}
                <div class="mt-10">
                    <button type="submit"
                        class="group relative w-full flex justify-center py-4 px-6 border border-transparent font-black uppercase tracking-widest rounded-xl text-white bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-1 shadow-lg hover:shadow-blue-200">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-300 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </span>
                        Generate Dokumen PDF
                    </button>
                    
                    <p class="text-center text-[10px] text-slate-400 mt-4 uppercase tracking-tighter">
                        Dokumen akan dibuka pada tab baru secara otomatis
                    </p>
                </div>
            </form>
        </div>

        <div class="text-center mt-6">
            <a href="{{ url()->previous() }}" class="text-sm text-slate-500 hover:text-blue-600 transition-colors flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Guru
            </a>
        </div>
    </div>
</div>
@endsection