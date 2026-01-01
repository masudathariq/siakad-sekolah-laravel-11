@extends('layouts.admin')

@section('page-title', 'Kelola Siswa Rombel')

@section('content')
<div class="space-y-6 animate-in fade-in duration-500 pb-10">

    {{-- SECTION 1: HEADER --}}
    <div class="bg-white rounded-[2.5rem] p-6 shadow-sm border border-slate-100 flex flex-col lg:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-gradient-to-br from-blue-700 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">
                    Kelola <span class="text-blue-600">Siswa Rombel</span>
                </h1>
                <p class="text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] mt-1 italic">
                    {{ $rombel->tahunAjaran->nama }} • Kelas {{ $rombel->tingkat->nama }} {{ $rombel->kode_kelas }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.rombel.show', $rombel->id) }}"
               class="px-6 py-3 bg-white text-slate-700 rounded-2xl hover:bg-slate-900 hover:text-white transition-all border border-slate-200 flex items-center gap-2 shadow-sm font-black text-[10px] uppercase italic tracking-widest">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="bg-emerald-500 text-white rounded-2xl px-6 py-4 shadow-lg shadow-emerald-100 border-none animate-in slide-in-from-top-4 duration-300">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                <span class="text-[11px] font-black uppercase italic tracking-widest">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.rombel.siswa.store', $rombel->id) }}" id="siswaForm">
        @csrf

        {{-- MAIN CARD --}}
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden">
            <div class="px-8 py-5 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-[11px] font-black text-slate-400 uppercase italic tracking-widest">Daftar Siswa Tersedia</h3>
                <span id="selectedCounter" class="bg-blue-600 text-white px-3 py-1 rounded-full text-[9px] font-black italic uppercase tracking-tighter">0 Terpilih</span>
            </div>

            @if($siswas->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-blue-600">
                                <th class="px-8 py-5 text-center w-20">
                                    <div class="flex justify-center">
                                        <input type="checkbox" id="select-all"
                                               class="w-5 h-5 rounded-lg border-2 border-blue-400 text-blue-800 focus:ring-offset-blue-600 focus:ring-white transition-all cursor-pointer bg-blue-500 checked:bg-white">
                                    </div>
                                </th>
                                <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-white italic border-l border-white/10">NISN</th>
                                <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-white italic border-l border-white/10">Nama Lengkap</th>
                                <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-white italic border-l border-white/10 text-center">Gender</th>
                            </tr>
                        </thead>
                        <tbody id="siswaTable" class="divide-y divide-slate-50 bg-white">
                            @foreach($siswas as $siswa)
                                <tr class="hover:bg-blue-50/40 transition-all group border-b border-slate-50">
                                    <td class="px-8 py-5 text-center">
                                        <div class="flex justify-center">
                                            <input type="checkbox" name="siswa[]" value="{{ $siswa->nisn }}"
                                                   class="w-5 h-5 rounded-lg border-2 border-slate-200 text-blue-600 focus:ring-blue-500 transition-all cursor-pointer checkbox-item group-hover:border-blue-300">
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="text-[13px] font-black text-slate-400 italic group-hover:text-blue-700 transition-colors">#{{ $siswa->nisn }}</span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="text-[13px] font-black text-slate-800 uppercase italic tracking-tight group-hover:text-blue-700 transition-colors">{{ $siswa->nama_siswa }}</span>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-xl text-[10px] font-black uppercase {{ $siswa->jenis_kelamin === 'L' ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                                            {{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-24 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-[2.5rem] flex items-center justify-center text-slate-200 mb-5 border border-slate-100 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <h3 class="text-[13px] font-black text-slate-400 uppercase italic tracking-[0.2em]">Semua Siswa Terdaftar</h3>
                        <p class="text-[10px] text-slate-300 font-bold uppercase mt-2">Tidak ada siswa yang tersedia untuk ditambahkan ke rombel.</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- FLOATING ACTION BAR --}}
        @if($siswas->count())
        <div class="mt-8 flex justify-end">
            <button type="button" onclick="konfirmasiSimpan()"
                    class="group flex items-center gap-3 px-10 py-5 bg-gradient-to-r from-blue-700 to-blue-500 text-white rounded-[2rem] hover:shadow-2xl hover:shadow-blue-200 transition-all active:scale-95 shadow-lg font-black text-[12px] uppercase italic tracking-[0.15em]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                Simpan Ke Rombel
            </button>
        </div>
        @endif
    </form>
</div>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.checkbox-item');
    const counter = document.getElementById('selectedCounter');

    function updateCounter() {
        const checkedCount = document.querySelectorAll('.checkbox-item:checked').length;
        counter.innerText = `${checkedCount} Terpilih`;
        if(checkedCount > 0) {
            counter.classList.replace('bg-blue-600', 'bg-emerald-500');
        } else {
            counter.classList.replace('bg-emerald-500', 'bg-blue-600');
        }
    }

    selectAll?.addEventListener('change', function(e) {
        checkboxes.forEach(cb => {
            cb.checked = e.target.checked;
        });
        updateCounter();
    });

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateCounter);
    });

    function konfirmasiSimpan() {
        const checkedCount = document.querySelectorAll('.checkbox-item:checked').length;
        
        if(checkedCount === 0) {
            Swal.fire({
                icon: 'error',
                title: '<span class="text-xl font-black uppercase italic tracking-tighter text-rose-600">Opps!</span>',
                text: 'Silakan pilih minimal satu siswa.',
                customClass: { popup: 'rounded-[3rem] p-10 border-8 border-white shadow-2xl' }
            });
            return;
        }

        Swal.fire({
            title: '<span class="text-2xl font-black uppercase italic tracking-tighter text-blue-600">Simpan Data?</span>',
            html: `<p class="text-[11px] font-black text-slate-500 uppercase tracking-widest italic text-center leading-relaxed">Anda akan menambahkan ${checkedCount} siswa ke rombel ini.</p>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'YA, SIMPAN SEKARANG',
            cancelButtonText: 'CEK LAGI',
            customClass: {
                popup: 'rounded-[3rem] p-10 border-8 border-white shadow-2xl',
                confirmButton: 'rounded-2xl px-8 py-4 font-black uppercase italic text-[11px] tracking-widest mx-2 shadow-lg bg-blue-600 text-white',
                cancelButton: 'rounded-2xl px-8 py-4 font-black uppercase italic text-[11px] tracking-widest mx-2 bg-slate-100 text-slate-600 shadow-sm'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('siswaForm').submit();
        });
    }
</script>
@endsection