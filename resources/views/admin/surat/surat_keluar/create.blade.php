@extends('layouts.admin')

@section('title', 'Tambah Surat Keluar')
@section('page-title', 'Tambah Surat Keluar')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-xl mx-auto bg-white p-5 rounded-xl shadow-md">

        <h1 class="text-2xl font-bold mb-6">Tambah Surat Keluar</h1>

        <a href="{{ route('admin.surat-keluar.index') }}" 
           class="mb-4 inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">
           ← Kembali
        </a>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.surat-keluar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Nomor Surat</label>
                <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Surat</label>
                <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tujuan</label>
                <input type="text" name="tujuan" value="{{ old('tujuan') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Perihal</label>
                <input type="text" name="perihal" value="{{ old('perihal') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Sifat</label>
                <select name="sifat" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400" required>
                    <option value="">-- Pilih Sifat --</option>
                    <option value="Biasa" {{ old('sifat')=='Biasa' ? 'selected' : '' }}>Biasa</option>
                    <option value="Penting" {{ old('sifat')=='Penting' ? 'selected' : '' }}>Penting</option>
                    <option value="Rahasia" {{ old('sifat')=='Rahasia' ? 'selected' : '' }}>Rahasia</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Kategori (Opsional)</label>
                <input type="text" name="kategori" value="{{ old('kategori') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Keterangan (Opsional)</label>
                <textarea name="keterangan" rows="3"
                          class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400">{{ old('keterangan') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">File PDF (Opsional)</label>
                <input type="file" name="file" accept="application/pdf" 
                       class="mt-1 block w-full text-sm border border-gray-300 rounded-lg px-3 py-2">
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.surat-keluar.index') }}" 
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">Batal</a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
