@extends('layouts.admin')

@section('page-title', 'Edit Surat Masuk')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-xl mx-auto bg-white p-5 rounded-xl shadow-md">

        <h1 class="text-2xl font-bold mb-6">Edit Surat Masuk</h1>

        <form action="{{ route('admin.surat-masuk.update', $surat->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Nomor Surat -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Nomor Surat</label>
                <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $surat->nomor_surat) }}" 
                       class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400" required>
            </div>

            <!-- Tanggal Surat & Tanggal Diterima -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Surat</label>
                    <input type="date" name="tanggal_surat" 
                           value="{{ old('tanggal_surat', \Carbon\Carbon::parse($surat->tanggal_surat)->format('Y-m-d')) }}" 
                           class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Diterima</label>
                    <input type="date" name="tanggal_diterima" 
                           value="{{ old('tanggal_diterima', \Carbon\Carbon::parse($surat->tanggal_diterima)->format('Y-m-d')) }}" 
                           class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400" required>
                </div>
            </div>

            <!-- Pengirim -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Asal / Pengirim</label>
                <input type="text" name="pengirim" value="{{ old('pengirim', $surat->pengirim) }}" 
                       class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400" required>
            </div>

            <!-- Perihal -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Perihal</label>
                <input type="text" name="perihal" value="{{ old('perihal', $surat->perihal) }}" 
                       class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400" required>
            </div>

            <!-- Sifat Surat -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Sifat Surat</label>
                <select name="sifat" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400" required>
                    <option value="">-- Pilih Sifat --</option>
                    <option value="Biasa" {{ old('sifat', $surat->sifat) == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                    <option value="Penting" {{ old('sifat', $surat->sifat) == 'Penting' ? 'selected' : '' }}>Penting</option>
                    <option value="Segera" {{ old('sifat', $surat->sifat) == 'Segera' ? 'selected' : '' }}>Segera</option>
                </select>
            </div>

            <!-- Kategori -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Kategori (Opsional)</label>
                <input type="text" name="kategori" value="{{ old('kategori', $surat->kategori) }}" 
                       class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400">
            </div>

            <!-- Tujuan -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Tujuan (Opsional)</label>
                <input type="text" name="tujuan" value="{{ old('tujuan', $surat->tujuan) }}" 
                       class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400">
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Keterangan (Opsional)</label>
                <textarea name="keterangan" rows="3" 
                          class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-300 focus:border-blue-400">{{ old('keterangan', $surat->keterangan) }}</textarea>
            </div>

            <!-- File PDF -->
            <div>
                <label class="block text-sm font-medium text-gray-700">File PDF (Opsional)</label>
                <input type="file" name="file" class="mt-1 block w-full text-sm">
                @if($surat->file)
                    <p class="text-sm text-gray-500 mt-1">
                        File saat ini: 
                        <a href="{{ asset('storage/' . $surat->file) }}" target="_blank" class="text-blue-600 hover:underline">
                            {{ $surat->file }}
                        </a>
                    </p>
                @endif
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.surat-masuk.index') }}" 
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">Batal</a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Update</button>
            </div>

        </form>
    </div>
</div>
@endsection
