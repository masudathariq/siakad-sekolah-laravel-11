@extends('layouts.admin')

@section('page-title', 'Detail Rombel')

@section('content')
<div class="space-y-6 animate-in fade-in duration-500 pb-10">
    
    {{-- SATU DIV UTAMA (ALL-IN-ONE CARD) --}}
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
        
        {{-- SECTION 1: HEADER & UTILITY --}}
        <div class="px-8 py-8 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-4 mb-1">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-700 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-slate-800 tracking-tighter italic uppercase leading-none">
                            Detail <span class="text-blue-600">Rombel</span>
                        </h1>
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] mt-1 italic">Manajemen Kelas & Siswa</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                {{-- Tombol Utama --}}
                <a href="{{ route('admin.rombel.siswa', $rombel->id) }}"
                   class="flex items-center gap-2 px-6 py-3 rounded-2xl transition shadow-lg shadow-emerald-100 font-black text-[10px] uppercase italic tracking-widest bg-emerald-500 text-white hover:bg-emerald-600 active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    Tambah Siswa
                </a>

                @if($rombel->tingkat->nama === 'IX')
                    <form method="POST" action="{{ route('admin.rombel.luluskan', $rombel->id) }}" onsubmit="return confirm('Yakin meluluskan semua siswa?')">
                        @csrf
                        <button class="px-6 py-3 bg-violet-600 text-white rounded-2xl font-black text-[10px] uppercase italic tracking-widest shadow-lg shadow-violet-100 hover:bg-violet-700 transition active:scale-95">
                            Luluskan Kelas
                        </button>
                    </form>
                @else
                    @if($tahunAjaranAktif)
                        <a href="{{ route('admin.rombel.naik-kelas', $rombel->id) }}"
                           class="px-6 py-3 bg-violet-600 text-white rounded-2xl font-black text-[10px] uppercase italic tracking-widest shadow-lg shadow-violet-100 hover:bg-violet-700 transition active:scale-95">
                            Naik Kelas
                        </a>
                    @else
                        <button disabled class="px-6 py-3 bg-slate-100 text-slate-400 rounded-2xl font-black text-[10px] uppercase italic tracking-widest cursor-not-allowed border border-slate-200">
                            Naik Kelas
                        </button>
                    @endif
                @endif

                <a href="{{ route('admin.rekap-absensi.index') }}?rombel_id={{ $rombel->id }}"
                   class="px-6 py-3 bg-amber-500 text-white rounded-2xl font-black text-[10px] uppercase italic tracking-widest shadow-lg shadow-amber-100 hover:bg-amber-600 transition active:scale-95">
                    Rekap Absen
                </a>
            </div>
        </div>

        {{-- SECTION 2: INFO RINGKAS (GRID) --}}
        <div class="px-8 py-8 bg-slate-50/50 border-b border-slate-100">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <div class="space-y-1">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Tahun Ajaran</p>
                    <p class="text-sm font-black text-slate-700 italic">{{ $rombel->tahunAjaran->nama }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Tingkat</p>
                    <p class="text-sm font-black text-slate-700 italic">KELAS {{ $rombel->tingkat->nama }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Nama Rombel</p>
                    <p class="text-sm font-black text-blue-600 italic uppercase">{{ $rombel->nama_kelas }}</p>
                </div>
                <div class="space-y-1 lg:col-span-1">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Wali Kelas</p>
                    <p class="text-sm font-black text-slate-700 italic truncate uppercase">{{ $rombel->waliKelas?->nama ?? '-' }}</p>
                </div>
                <div class="bg-white p-4 rounded-[1.5rem] border border-slate-200 shadow-sm text-center group hover:border-blue-300 transition-colors">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Total Siswa</p>
                    <p class="text-2xl font-black text-slate-800 leading-none mt-1 group-hover:text-blue-600">{{ $rombel->siswas->count() }}</p>
                </div>
                <div class="bg-white p-4 rounded-[1.5rem] border border-slate-200 shadow-sm text-center group hover:border-blue-300 transition-colors">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Laki / Peremp</p>
                    <p class="text-2xl font-black text-slate-800 leading-none mt-1">
                        <span class="text-blue-600">{{ $rombel->siswas->where('jenis_kelamin','L')->count() }}</span>
                        <span class="text-slate-300 mx-1">/</span>
                        <span class="text-rose-500">{{ $rombel->siswas->where('jenis_kelamin','P')->count() }}</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- SECTION 3: EXPORT & BACK --}}
        <div class="px-8 py-4 bg-white border-b border-slate-100 flex flex-wrap justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mr-2">Export Data:</span>
       <a href="{{ route('admin.rombel.preview', $rombel->id) }}" target="_blank"
            class="px-4 py-2 bg-red-600 border border-red-700 rounded-xl text-[10px] font-black uppercase text-white hover:bg-red-700 transition-all shadow-sm">
                PDF Preview
        </a>
        <a href="{{ route('admin.rombel.export', $rombel->id) }}" 
        class="px-4 py-2 bg-green-600 border border-green-700 rounded-xl text-[10px] font-black uppercase text-white hover:bg-green-700 transition-all shadow-sm">
        Excel Sheet
        </a>

            </div>
            <a href="{{ route('admin.rombel.index', ['tahun_ajaran' => $rombel->tahun_ajaran_id]) }}" class="text-[10px] font-black uppercase text-blue-600 italic hover:text-blue-800 flex items-center gap-2 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" /></svg>
                Kembali ke Daftar Rombel 
            </a>
        </div>

        {{-- SECTION 4: TABEL SISWA --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-600">
                        <th class="px-6 py-5 text-[11px] font-black uppercase tracking-widest text-center text-white italic w-20">NO</th>
                        <th class="px-6 py-5 text-[11px] font-black uppercase tracking-widest border-l border-white/10 text-white italic">NISN</th>
                        <th class="px-6 py-5 text-[11px] font-black uppercase tracking-widest border-l border-white/10 text-white italic">Nama Lengkap Siswa</th>
                        <th class="px-6 py-5 text-[11px] font-black uppercase tracking-widest border-l border-white/10 text-center text-white italic">JK</th>
                        <th class="px-6 py-5 text-[11px] font-black uppercase tracking-widest border-l border-white/10 text-center text-white italic">Kontrol Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rombel->siswas as $siswa)
                        <tr class="hover:bg-blue-50/40 transition-all group">
                            <td class="px-6 py-5 text-center text-xs font-black text-slate-900 group-hover:text-blue-600">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-5 text-xs font-bold text-slate-900 font-mono italic">
                                {{ $siswa->nisn }}
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-[13px] font-black text-slate-800 uppercase italic group-hover:text-blue-700 transition-colors">{{ $siswa->nama_siswa }}</div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl text-[10px] font-black uppercase {{ $siswa->jenis_kelamin === 'L' ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                                    {{ $siswa->jenis_kelamin }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex justify-center items-center gap-4">
                                    <a href="{{ route('admin.siswa.edit', $siswa->nisn) }}" class="text-[10px] font-black uppercase text-emerald-600 hover:text-emerald-700 italic border-b-2 border-transparent hover:border-emerald-600 transition-all tracking-widest">Edit</a>
                                    
                                    <a href="{{ route('admin.rombel.siswa.pindah', [$rombel->id, $siswa->nisn]) }}" class="text-[10px] font-black uppercase text-indigo-600 hover:text-indigo-700 italic border-b-2 border-transparent hover:border-indigo-600 transition-all tracking-widest">Pindah</a>

                                    <form method="POST" action="{{ route('admin.rombel.siswa.keluar', [$rombel->id, $siswa->nisn]) }}" onsubmit="return confirm('Yakin mengeluarkan {{ $siswa->nama_siswa }}?')">
                                        @csrf @method('DELETE')
                                        <button class="text-[10px] font-black uppercase text-rose-500 hover:text-rose-700 italic border-b-2 border-transparent hover:border-rose-600 transition-all tracking-widest">Keluarkan</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2.5rem] flex items-center justify-center text-slate-200 mb-4 border border-slate-100 shadow-inner">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    </div>
                                    <h3 class="text-[13px] font-black text-slate-400 uppercase italic tracking-[0.3em]">Belum Ada Siswa</h3>
                                    <p class="text-[10px] text-slate-300 font-bold uppercase mt-2">Silakan tambahkan siswa ke rombel ini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection