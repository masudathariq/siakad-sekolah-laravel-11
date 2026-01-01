@extends('layouts.admin')

@section('title', 'Buat Format Absen Bulanan')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Buat Format Absen Bulanan</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.rombel.cetak-absen') }}" method="POST" target="_blank">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold">Rombel</label>
            <select name="rombel_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih Rombel --</option>
                @foreach($rombels as $rombel)
                    <option value="{{ $rombel->id }}">
                        {{ $rombel->tingkat->nama ?? '-' }} - {{ $rombel->kode_kelas }} {{ $rombel->nama_kelas ?? '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Bulan</label>
            <select name="bulan" class="w-full border rounded px-3 py-2" required>
                @foreach(range(1,12) as $m)
                    <option value="{{ $m }}">{{ \Carbon\Carbon::create(2025,$m,1)->translatedFormat('F') }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Tahun</label>
            <input type="number" name="tahun" class="w-full border rounded px-3 py-2" value="{{ date('Y') }}" required>
        </div>

        {{-- Input Tanggal Merah Manual --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Tanggal Merah (opsional)</label>
            <div id="tanggal-merah-container">
                <div class="flex gap-2 mb-2">
                    <input type="date" name="tanggal_merah_manual[]" class="w-full border rounded px-3 py-2">
                    <input type="text" name="keterangan_tanggal_merah[]" class="w-full border rounded px-3 py-2" placeholder="Keterangan">
                    <button type="button" onclick="hapusInput(this)" class="bg-red-500 text-white px-2 rounded hover:bg-red-600">✖</button>
                </div>
            </div>
            <button type="button" onclick="tambahInput()" class="mt-2 bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                ➕ Tambah Tanggal Merah
            </button>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Cetak Absen</button>
    </form>
</div>

<script>
function tambahInput() {
    const container = document.getElementById('tanggal-merah-container');
    const div = document.createElement('div');
    div.classList.add('flex', 'gap-2', 'mb-2');

    div.innerHTML = `
        <input type="date" name="tanggal_merah_manual[]" class="w-full border rounded px-3 py-2">
        <input type="text" name="keterangan_tanggal_merah[]" class="w-full border rounded px-3 py-2" placeholder="Keterangan">
        <button type="button" onclick="hapusInput(this)" class="bg-red-500 text-white px-2 rounded hover:bg-red-600">✖</button>
    `;
    container.appendChild(div);
}

function hapusInput(button) {
    button.parentElement.remove();
}
</script>
@endsection
