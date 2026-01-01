@extends('layouts.admin')

@section('title', 'Detail Surat Keluar')
@section('page-title', 'Detail Surat Keluar')

@section('content')
<div class="p-6 bg-slate-50 min-h-screen">

    <h1 class="text-2xl font-bold mb-4">📄 Detail Surat Keluar</h1>

    <a href="{{ route('admin.surat-keluar.index') }}"
       class="mb-4 inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
        ← Kembali
    </a>

    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="mb-4">
            <strong>Nomor Surat:</strong> {{ $surat->nomor_surat }}
        </div>
        <div class="mb-4">
            <strong>Tanggal Surat:</strong> {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}
        </div>
        <div class="mb-4">
            <strong>Tujuan:</strong> {{ $surat->tujuan }}
        </div>
        <div class="mb-4">
            <strong>Perihal:</strong> {{ $surat->perihal }}
        </div>
        <div class="mb-4">
            <strong>Sifat:</strong> {{ $surat->sifat }}
        </div>
        <div class="mb-4">
            <strong>Kategori:</strong> {{ $surat->kategori ?? '-' }}
        </div>
        <div class="mb-4">
            <strong>Keterangan:</strong> {{ $surat->keterangan ?? '-' }}
        </div>
        <div class="mb-4">
            <strong>File PDF:</strong>
            @if($surat->file)
                <a href="{{ route('admin.surat-keluar.preview-pdf', $surat->id) }}" target="_blank" class="text-blue-600 hover:underline">
                    Lihat PDF
                </a>
            @else
                -
            @endif
        </div>
    </div>

</div>
@endsection
