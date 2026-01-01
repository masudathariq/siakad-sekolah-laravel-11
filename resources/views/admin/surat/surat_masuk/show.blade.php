@extends('layouts.admin')

@section('content')
<div class="p-6 bg-slate-50 min-h-screen max-w-3xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">📄 Detail Surat Masuk</h1>

    <div class="bg-white p-6 rounded-xl shadow-md space-y-3">
        <p><strong>Nomor Surat:</strong> {{ $surat->nomor_surat }}</p>
        <p><strong>Tanggal Surat:</strong> {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}</p>
        <p><strong>Tanggal Diterima:</strong> {{ \Carbon\Carbon::parse($surat->tanggal_diterima)->translatedFormat('d F Y') }}</p>
        <p><strong>Pengirim:</strong> {{ $surat->pengirim }}</p>
        <p><strong>Perihal:</strong> {{ $surat->perihal }}</p>
        <p><strong>Sifat:</strong> {{ $surat->sifat }}</p>
        <p><strong>Kategori:</strong> {{ $surat->kategori }}</p>
        <p><strong>Tujuan:</strong> {{ $surat->tujuan }}</p>
        <p><strong>Keterangan:</strong> {{ $surat->keterangan }}</p>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.surat-masuk.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Kembali</a>
    </div>

</div>
@endsection
