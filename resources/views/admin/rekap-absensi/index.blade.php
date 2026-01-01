@extends('layouts.admin')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="p-6 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        
        {{-- HEADER CARD DENGAN BLUE GRADIENT --}}
        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden mb-6">
            <div class="px-8 py-8 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-2 h-10 rounded-full bg-blue-600"></div>
                        <h1 class="text-3xl font-black text-slate-800 tracking-tighter italic uppercase leading-none">
                            Rekap <span class="text-blue-600">Absensi</span>
                        </h1>
                    </div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] ml-6 italic">Laporan Bulanan Siswa</p>
                </div>

                {{-- FORM FILTER CEPAT (Hanya untuk Tampilkan Data) --}}
                <form method="GET" action="{{ route('admin.rekap-absensi.index') }}" class="flex flex-wrap items-center gap-3">
                    <input type="hidden" name="rombel_id" value="{{ $rombel->id }}">
                    
                    <div class="flex items-center bg-slate-100 rounded-xl px-3 py-1 border border-slate-200">
                        {{-- Filter Bulan --}}
                        <select name="bulan" class="bg-transparent border-none text-xs font-black uppercase italic text-slate-700 focus:ring-0 cursor-pointer">
                            @foreach(range(1,12) as $b)
                                <option value="{{ $b }}" {{ (int)$bulan === $b ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                        {{-- Filter Tahun --}}
                        <input type="number" name="tahun" value="{{ $tahun }}" class="bg-transparent border-none text-xs font-black w-20 text-slate-700 focus:ring-0">
                    </div>

                    <button type="submit" class="bg-slate-900 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase italic tracking-widest hover:bg-blue-600 transition-all shadow-lg active:scale-95">
                        Tampilkan
                    </button>

                    <button type="button" onclick="cetakPdf()" class="bg-rose-500 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase italic tracking-widest hover:bg-rose-600 transition-all shadow-lg shadow-rose-100 active:scale-95">
                        🖨 Cetak PDF
                    </button>
                </form>
            </div>

            {{-- INFO ROMBEL MINI --}}
            <div class="px-8 py-4 bg-blue-600 flex flex-wrap gap-8">
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-black text-blue-200 uppercase tracking-widest">Rombel:</span>
                    <span class="text-sm font-black text-white italic uppercase">{{ $rombel->nama_kelas }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-black text-blue-200 uppercase tracking-widest">Periode:</span>
                    <span class="text-sm font-black text-white italic uppercase">{{ $tahunAjaran->nama }}</span>
                </div>
            </div>
        </div>

        {{-- MAIN DATA FORM & TABLE --}}
        <form method="POST" action="{{ route('admin.rekap-absensi.store') }}">
            @csrf
            <input type="hidden" name="rombel_id" value="{{ $rombel->id }}">
            <input type="hidden" name="bulan" value="{{ $bulan }}">
            <input type="hidden" name="tahun" value="{{ $tahun }}">

            {{-- STICKY SETTING: HARI EFEKTIF (Blue Gradient Style) --}}
            <div class="mb-6 flex items-center bg-white p-4 rounded-3xl border border-slate-100 shadow-sm w-fit gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white shadow-lg shadow-blue-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Total Hari Kerja</p>
                        <p class="text-[9px] text-slate-500 italic">Nilai ini disimpan permanen untuk periode ini</p>
                    </div>
                </div>
                
                <div class="h-10 w-[2px] bg-slate-100 mx-2"></div>

                <input type="number" 
                       name="hari_efektif" 
                       id="hari_efektif_input" 
                       value="{{ $savedHariEfektif }}" 
                       required
                       class="w-16 h-12 bg-slate-50 border-2 border-slate-100 rounded-2xl text-center text-lg font-black text-blue-600 focus:border-blue-500 focus:ring-0 transition-all">
            </div>

            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-900">
                                <th class="px-6 py-5 text-[10px] font-black text-white uppercase tracking-widest text-center">NISN</th>
                                <th class="px-6 py-5 text-[10px] font-black text-white uppercase tracking-widest border-l border-white/10">Nama Lengkap Siswa</th>
                                @foreach(['hadir' => 'bg-emerald-500', 'izin' => 'bg-blue-500', 'sakit' => 'bg-amber-500', 'alpha' => 'bg-rose-500', 'bolos' => 'bg-slate-700'] as $status => $color)
                                    <th class="px-4 py-5 text-[10px] font-black text-white uppercase tracking-widest text-center border-l border-white/10 {{ $color }}">
                                        {{ $status }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($rombel->siswas as $siswa)
                                @php $d = $rekap[$siswa->nisn] ?? null; @endphp
                                <tr class="hover:bg-blue-50/50 transition-colors group">
                                    <td class="px-6 py-4 text-xs font-bold text-slate-400 font-mono text-center">{{ $siswa->nisn }}</td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-black text-slate-700 uppercase italic group-hover:text-blue-600 transition-colors">
                                            {{ $siswa->nama_siswa }}
                                        </div>
                                    </td>
                                    
                                    @foreach(['hadir','izin','sakit','alpha','bolos'] as $s)
                                        <td class="px-4 py-4 text-center border-l border-slate-50">
                                            <input type="number" 
                                                   name="absensi[{{ $siswa->nisn }}][{{ $s }}]" 
                                                   value="{{ $d->$s ?? 0 }}" 
                                                   class="w-14 h-10 border-2 border-slate-100 rounded-xl text-center text-xs font-black focus:border-blue-500 focus:ring-0 transition-all bg-slate-50 group-hover:bg-white">
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="bg-emerald-500 text-white px-8 py-4 rounded-2xl text-xs font-black uppercase italic tracking-[0.2em] hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-100 active:scale-95 flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        Simpan Rekap & Hari Kerja
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function cetakPdf() {
    const btn = event.currentTarget;
    const originalText = btn.innerHTML;
    
    // Ambil nilai hari efektif dari input yang ada di dalam form simpan
    const hariEfektif = document.getElementById('hari_efektif_input').value;

    btn.innerHTML = "⏳ Generating...";
    btn.disabled = true;

    fetch("{{ route('admin.rekap-absensi.pdf') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            rombel_id: {{ $rombel->id }},
            bulan: {{ $bulan }},
            tahun: {{ $tahun }},
            hari_efektif: hariEfektif 
        })
    })
    .then(res => res.json())
    .then(data => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        
        const win = window.open("", "_blank");
        win.document.write(`
            <html>
            <head><title>Cetak Rekap Absensi - {{ $rombel->nama_kelas }}</title></head>
            <body style="margin:0;padding:0;overflow:hidden">
                <iframe src="data:${data.mime};base64,${data.base64}" width="100%" height="100%" style="border:none;"></iframe>
            </body>
            </html>
        `);
    })
    .catch(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        alert('Gagal membuat PDF. Pastikan data tersedia.');
    });
}
</script>
@endsection