@extends('layouts.admin')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="bg-white p-6 rounded shadow">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label>Nama</label>
        <input type="text" name="name" class="w-full border p-2 rounded" value="{{ old('name', $user->name) }}">
    </div>
    <div class="mb-4">
        <label>Email</label>
        <input type="email" name="email" class="w-full border p-2 rounded" value="{{ old('email', $user->email) }}">
    </div>
    <div class="mb-4">
        <label>Password (kosongkan jika tidak diganti)</label>
        <input type="password" name="password" class="w-full border p-2 rounded">
    </div>
    <div class="mb-4">
        <label>Role</label>
        <select name="role" class="w-full border p-2 rounded">
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="karyawan" {{ $user->role == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
        </select>
    </div>
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
</form>
@endsection
