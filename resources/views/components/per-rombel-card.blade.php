@props(['rombel'])

@php
    // Aman untuk stdClass maupun Eloquent
    $nama = $rombel->nama ?? 'Tidak Diketahui';
    $jumlahSiswa = $rombel->jumlah_siswa ?? 0;
    $jumlahLaki = $rombel->jumlah_laki ?? 0;
    $jumlahPerempuan = $rombel->jumlah_perempuan ?? 0;

    $persenLaki = $jumlahSiswa > 0 ? round($jumlahLaki / $jumlahSiswa * 100) : 0;
    $persenPerempuan = 100 - $persenLaki;

    $dominanGender = $jumlahLaki > $jumlahPerempuan ? 'Laki-laki' : ($jumlahPerempuan > $jumlahLaki ? 'Perempuan' : 'Seimbang');
@endphp

<div class="bg-white/10 backdrop-blur-2xl border border-white/10 rounded-[2.5rem] p-7 hover:bg-white/20 transition-all duration-500">
    <!-- Header -->
    <div class="flex justify-between items-center mb-5">
        <div class="h-14 w-14 bg-white rounded-2xl flex items-center justify-center text-blue-800 font-bold text-xl italic">
            {{ $nama }}
        </div>
        <div class="text-right">
            <p class="text-[11px] text-blue-200/70 uppercase tracking-wide">Jumlah Siswa</p>
            <p class="text-2xl md:text-3xl font-extrabold text-white italic">{{ $jumlahSiswa }}</p>
        </div>
    </div>

    <!-- Ringkasan -->
    <div class="bg-white/5 rounded-2xl p-4 border border-white/10 mb-5 text-[11px] md:text-sm text-white/90">
        Mayoritas siswa didominasi oleh <span class="font-semibold text-rose-300">{{ $dominanGender }}</span>.
    </div>

    <!-- Progress -->
    <div class="mb-5">
        <div class="w-full h-3 bg-black/30 rounded-full overflow-hidden flex p-0.5">
            <div class="h-full bg-blue-500 rounded-full" style="width: {{ $persenLaki }}%"></div>
            <div class="h-full bg-rose-500 rounded-full ml-1" style="width: {{ $persenPerempuan }}%"></div>
        </div>
        <div class="flex justify-between mt-2 text-[11px] font-semibold">
            <span class="text-blue-300">{{ $persenLaki }}% Laki-laki</span>
            <span class="text-rose-300">{{ $persenPerempuan }}% Perempuan</span>
        </div>
    </div>

    <!-- Detail -->
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-blue-50/30 rounded-xl p-4 text-center border border-blue-100">
            <p class="text-[11px] font-bold uppercase opacity-70 mb-1 tracking-wider">Laki-laki</p>
            <p class="text-lg font-black text-white">{{ $jumlahLaki }}</p>
        </div>
        <div class="bg-rose-50/30 rounded-xl p-4 text-center border border-rose-100">
            <p class="text-[11px] font-bold uppercase opacity-70 mb-1 tracking-wider">Perempuan</p>
            <p class="text-lg font-black text-white">{{ $jumlahPerempuan }}</p>
        </div>
    </div>
</div>
