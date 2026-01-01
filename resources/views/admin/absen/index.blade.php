@extends('layouts.admin')

@section('page-title', 'Presensi Siswa')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-6">
    
    {{-- Main Blue Gradient Card --}}
    <div class="bg-gradient-to-br from-blue-700 via-blue-600 to-blue-800 rounded-[3rem] shadow-[0_25px_50px_-12px_rgba(29,78,216,0.4)] overflow-hidden relative border border-white/10">
        
        {{-- Decorative Decor --}}
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-blue-400/20 rounded-full blur-3xl"></div>

        <div class="relative z-10 p-10 lg:p-12">
            {{-- Header --}}
            <div class="mb-10 flex items-center gap-6">
                <div class="p-4 bg-white/15 backdrop-blur-xl rounded-2xl border border-white/20 shadow-inner">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-white tracking-tighter leading-none">Presensi Siswa</h1>
                    <p class="text-blue-100/70 text-[10px] font-bold uppercase tracking-[0.2em] mt-2">Generate laporan absensi bulanan</p>
                </div>
            </div>

            <form id="form-absen" action="{{ route('admin.absen.preview') }}" method="GET" target="_blank" class="space-y-6">
                @csrf

                {{-- ROMBEL --}}
                <div class="space-y-2 group">
                    <label class="text-[10px] font-black text-blue-100 uppercase tracking-widest ml-1 opacity-80">Rombongan Belajar</label>
                    <div class="relative">
                        <select name="rombel_id" class="w-full bg-white text-slate-900 border-none rounded-2xl px-6 py-4 font-bold text-sm focus:ring-4 focus:ring-blue-400/50 transition-all shadow-xl appearance-none" required>
                            <option value="">-- Pilih Rombel --</option>
                            <option value="semua" class="font-black text-blue-600 italic">** Cetak Semua Rombel **</option>
                            @foreach($rombels as $rombel)
                                <option value="{{ $rombel->id }}">
                                    {{ $rombel->tingkat->nama ?? '-' }} - {{ $rombel->kode_kelas }} {{ $rombel->nama_kelas ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    {{-- BULAN --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-blue-100 uppercase tracking-widest ml-1 opacity-80">Bulan</label>
                        <select name="bulan" class="w-full bg-white text-slate-900 border-none rounded-2xl px-6 py-4 font-bold text-sm shadow-xl focus:ring-4 focus:ring-blue-400/50 transition-all" required>
                            @foreach(range(1,12) as $m)
                                <option value="{{ $m }}" {{ $m == date('m') ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create(date('Y'),$m,1)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TAHUN --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-blue-100 uppercase tracking-widest ml-1 opacity-80">Tahun</label>
                        <input type="number" name="tahun" value="{{ date('Y') }}" class="w-full bg-white text-slate-900 border-none rounded-2xl px-6 py-4 font-bold text-sm shadow-xl focus:ring-4 focus:ring-blue-400/50 transition-all" required>
                    </div>
                </div>

                {{-- SEMESTER --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-blue-100 uppercase tracking-widest ml-1 opacity-80">Semester</label>
                    <select name="semester" class="w-full bg-white text-slate-900 border-none rounded-2xl px-6 py-4 font-bold text-sm shadow-xl focus:ring-4 focus:ring-blue-400/50 transition-all" required>
                        <option value="">-- Pilih Semester --</option>
                        <option value="ganjil">Ganjil</option>
                        <option value="genap">Genap</option>
                    </select>
                </div>

                {{-- TANGGAL MERAH --}}
                <div class="mt-8 p-6 bg-white/5 rounded-[2.5rem] border border-white/10 backdrop-blur-sm">
                    <div class="flex items-center justify-between mb-4">
                        <label class="text-[10px] font-black text-white uppercase tracking-widest">Libur / Tanggal Merah <span class="lowercase opacity-40 font-normal italic">(opsional)</span></label>
                    </div>

                    <div id="container-tanggal-merah" class="space-y-3">
                        <div class="flex gap-2 group transition-all">
                            <input type="date" class="tgl-input w-1/3 bg-white border-none rounded-xl px-3 py-2 text-xs font-bold focus:ring-2 focus:ring-blue-400">
                            <input type="text" class="ket-input w-2/3 bg-white border-none rounded-xl px-3 py-2 text-xs font-bold focus:ring-2 focus:ring-blue-400" placeholder="Keterangan Libur">
                            <input type="hidden" name="tanggal_merah[]" class="hidden-input">
                            <button type="button" class="btn-remove px-3 bg-white/10 text-white rounded-xl hover:bg-rose-500 hover:scale-110 transition-all">✕</button>
                        </div>
                    </div>

                    <button type="button" id="btn-add" class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-500/30 border border-white/20 text-white text-[10px] font-black uppercase tracking-widest hover:bg-blue-500/50 hover:shadow-lg transition-all">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        Tambah Hari Libur
                    </button>
                </div>

                {{-- SUBMIT --}}
                <button type="submit" class="w-full py-5 bg-white text-blue-700 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.3em] shadow-2xl hover:bg-blue-50 hover:shadow-blue-900/40 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Buka Preview PDF
                </button>
            </form>
        </div>
    </div>
</div>

<script>
// Logic Tetap Sama, Hanya Penyesuaian Style pada Button Dinamis
const container = document.getElementById('container-tanggal-merah');
const bulanSelect = document.querySelector('select[name="bulan"]');
const tahunInput = document.querySelector('input[name="tahun"]');

function setTanggalDefault(input){
    const bulan = parseInt(bulanSelect.value);
    const tahun = parseInt(tahunInput.value);
    if(bulan && tahun){
        input.value = `${tahun}-${String(bulan).padStart(2,'0')}-01`;
    }
}

function updateTanggalSemua(){
    document.querySelectorAll('.tgl-input').forEach(input => setTanggalDefault(input));
}

document.getElementById('btn-add').addEventListener('click', function() {
    const div = document.createElement('div');
    div.className = 'flex gap-2 group animate-in slide-in-from-top-2 duration-300';
    div.innerHTML = `
        <input type="date" class="tgl-input w-1/3 bg-white border-none rounded-xl px-3 py-2 text-xs font-bold focus:ring-2 focus:ring-blue-400">
        <input type="text" class="ket-input w-2/3 bg-white border-none rounded-xl px-3 py-2 text-xs font-bold focus:ring-2 focus:ring-blue-400" placeholder="Keterangan Libur">
        <input type="hidden" name="tanggal_merah[]" class="hidden-input">
        <button type="button" class="btn-remove px-3 bg-white/10 text-white rounded-xl hover:bg-rose-500 hover:scale-110 transition-all">✕</button>
    `;
    container.appendChild(div);
    setTanggalDefault(div.querySelector('.tgl-input'));
});

container.addEventListener('click', e => {
    if(e.target.classList.contains('btn-remove')){
        e.target.parentElement.classList.add('opacity-0', 'scale-95');
        setTimeout(() => e.target.parentElement.remove(), 200);
    }
});

bulanSelect.addEventListener('change', updateTanggalSemua);
tahunInput.addEventListener('change', updateTanggalSemua);

updateTanggalSemua();

document.getElementById('form-absen').addEventListener('submit', function(){
    container.querySelectorAll('.flex').forEach(div=>{
        const tgl = div.querySelector('.tgl-input').value;
        const ket = div.querySelector('.ket-input').value;
        div.querySelector('.hidden-input').value = tgl && ket ? `${tgl}:${ket}` : '';
    });
});
</script>
@endsection