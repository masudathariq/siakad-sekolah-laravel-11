@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-xl mx-auto"> <!-- Lebih sempit, formal -->

        <h1 class="text-2xl font-bold mb-6">Tambah Surat Masuk</h1>

        <form action="{{ route('admin.surat-masuk.store') }}" method="POST" enctype="multipart/form-data" 
              class="bg-white p-5 rounded-xl shadow-md space-y-4">
            @csrf

            <!-- Nomor Surat -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Nomor Surat</label>
                <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}" 
                       class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400">
            </div>

            <!-- Tanggal Surat & Tanggal Diterima -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Surat</label>
                    <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}" 
                           class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Diterima</label>
                    <input type="date" name="tanggal_diterima" value="{{ old('tanggal_diterima') }}" 
                           class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400">
                </div>
            </div>

            <!-- Pengirim -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Pengirim</label>
                <input type="text" name="pengirim" value="{{ old('pengirim') }}" 
                       class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400">
            </div>

            <!-- Perihal -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Perihal</label>
                <input type="text" name="perihal" value="{{ old('perihal') }}" 
                       class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400">
            </div>

            <!-- Sifat -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Sifat</label>
                <select name="sifat" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400">
                    <option value="Biasa" {{ old('sifat')=='Biasa'?'selected':'' }}>Biasa</option>
                    <option value="Penting" {{ old('sifat')=='Penting'?'selected':'' }}>Penting</option>
                    <option value="Segera" {{ old('sifat')=='Segera'?'selected':'' }}>Segera</option>
                    <option value="Rahasia" {{ old('sifat')=='Rahasia'?'selected':'' }}>Rahasia</option>
                </select>
            </div>

            <!-- Kategori -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori') }}" 
                       class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400">
            </div>

            <!-- Tujuan -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Tujuan</label>
                <input type="text" name="tujuan" value="{{ old('tujuan') }}" 
                       class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400">
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                <textarea name="keterangan" rows="3" 
                          class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400">{{ old('keterangan') }}</textarea>
            </div>

            <!-- File PDF -->
            <div>
                <label class="block text-sm font-medium text-gray-700">File PDF (opsional)</label>
                <input type="file" name="file" accept="application/pdf" class="mt-1 block w-full text-sm">
            </div>

            <!-- Tombol -->
            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.surat-masuk.index') }}" 
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Simpan</button>
            </div>

        </form>
    </div>
</div>
@endsection
