@extends('layouts.admin')

@section('content')
<div style="padding:20px;max-width:900px">

<h2>🔼 Naik Kelas</h2>

<div style="background:#fff;padding:15px;border-radius:8px;margin-bottom:20px">
    <h4>Rombel Asal</h4>
    <p><strong>Tahun:</strong> {{ $rombel->tahunAjaran->nama }}</p>
    <p><strong>Tingkat:</strong> {{ $rombel->tingkat->nama }}</p>
    <p><strong>Kelas:</strong> {{ $rombel->kode_kelas }}</p>
</div>

<form method="POST" action="{{ route('admin.rombel.naik-kelas.proses', $rombel->id) }}">
@csrf

<label><strong>Pilih Rombel Tujuan</strong></label>
<select name="rombel_tujuan_id" required
    style="width:100%;padding:8px;margin-bottom:15px">
    <option value="">-- Pilih Rombel --</option>
    @foreach($rombelsTujuan as $tujuan)
        <option value="{{ $tujuan->id }}">
            {{ $tujuan->tahunAjaran->nama }} -
            {{ $tujuan->tingkat->nama }}
            {{ $tujuan->kode_kelas }}
        </option>
    @endforeach
</select>

<p><strong>Jumlah Siswa:</strong> {{ $rombel->siswas->count() }}</p>

<button
style="padding:10px 16px;background:#16a34a;
color:#fff;border-radius:6px;border:none">
🔼 Proses Naik Kelas
</button>

<a href="{{ route('admin.rombel.show', $rombel->id) }}"
style="margin-left:10px">Batal</a>

</form>

</div>
@endsection
