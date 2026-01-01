@extends('layouts.admin')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User Baru')

@section('content')
<form action="{{ route('admin.users.store') }}" method="POST" class="bg-white p-6 rounded shadow">
    @csrf
    <div class="mb-4">
        <label>Nama</label>
        <input type="text" name="name" class="w-full border p-2 rounded" value="{{ old('name') }}">
    </div>
    <div class="mb-4">
        <label>Email</label>
        <input type="email" name="email" class="w-full border p-2 rounded" value="{{ old('email') }}">
    </div>
    <div class="mb-4">
        <label>Password</label>
        <input type="password" name="password" class="w-full border p-2 rounded">
    </div>
    <div class="mb-4">
        <label>Role</label>
        <select name="role" class="w-full border p-2 rounded">
            <option value="admin">Admin</option>
            <option value="karyawan">Karyawan</option>
        </select>
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
</form>
@endsection
