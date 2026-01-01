@extends('layouts.admin')

@section('page-title', 'Pindahkan Siswa')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.rombel.show', $rombel->id) }}" class="flex items-center text-slate-500 hover:text-indigo-600 transition-colors group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="text-sm font-bold uppercase tracking-wider">Kembali ke Detail Rombel</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <div class="bg-amber-50/50 border-b border-slate-100 p-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-800 uppercase tracking-tight">Pindahkan Siswa</h2>
                    <p class="text-[10px] font-bold text-amber-600 uppercase tracking-widest mt-1">Mutasi kelas dalam tahun ajaran aktif</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="flex flex-col md:flex-row items-center gap-4 p-6 bg-slate-50 rounded-3xl border border-slate-100 mb-8">
                <div class="flex-1 text-center md:text-left">
                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nama Siswa</span>
                    <span class="text-lg font-black text-slate-800">{{ $siswa->nama_siswa }}</span>
                    <span class="block text-xs font-bold text-slate-500 mt-1">NISN: {{ $siswa->nisn }}</span>
                </div>
                
                <div class="hidden md:block">
                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                </div>

                <div class="flex-1 text-center md:text-left">
                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Rombel Asal</span>
                    <span class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-black uppercase tracking-tight">
                        {{ $rombel->tingkat->nama }} {{ $rombel->kode_kelas }}
                    </span>
                    <span class="block text-[10px] font-bold text-slate-400 mt-2 uppercase italic tracking-tighter">
                        Tahun: {{ $rombel->tahunAjaran->nama }}
                    </span>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.rombel.siswa.pindah.store', [$rombel->id, $siswa->nisn]) }}" id="form-pindah">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Pilih Rombel Tujuan</label>
                    <div class="relative group">
                        <select name="rombel_id" required 
                                class="w-full px-5 py-4 bg-white border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold text-slate-700 appearance-none cursor-pointer">
                            <option value="">-- Pilih Rombel Tujuan --</option>
                            @foreach($rombels as $r)
                                @if($r->tahunAjaran->aktif)
                                    <option value="{{ $r->id }}" class="py-2">
                                        {{ $r->tingkat->nama }} {{ $r->kode_kelas }} — {{ $r->nama_kelas ?? 'Tanpa Nama' }} ({{ $r->tahunAjaran->nama }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-slate-400 group-hover:text-emerald-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-4">
                    <a href="{{ route('admin.rombel.show', $rombel->id) }}" 
                       class="w-full sm:w-auto text-center px-8 py-4 text-xs font-black text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-widest">
                        Batal
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto px-10 py-4 bg-emerald-500 text-white text-xs font-black rounded-2xl shadow-xl shadow-emerald-100 hover:bg-emerald-600 hover:-translate-y-1 active:scale-95 transition-all uppercase tracking-widest flex items-center justify-center gap-2">
                        <span>Konfirmasi Pindah</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-6 p-4 bg-blue-50 rounded-2xl border border-blue-100 flex items-start gap-3">
        <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-[11px] text-blue-700 font-medium leading-relaxed uppercase tracking-tight">
            <strong>Catatan Penting:</strong> Riwayat nilai dan absensi pada rombel asal akan tetap tersimpan, namun siswa akan terdaftar sebagai anggota aktif di rombel yang baru.
        </p>
    </div>
</div>
@endsection