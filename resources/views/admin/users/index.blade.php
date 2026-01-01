@extends('layouts.admin')

@section('title', 'Users')
@section('page-title', 'Daftar Users')

@section('content')
<a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">Tambah User</a>

@if(session('success'))
    <div class="bg-green-500 text-white p-2 rounded mb-4">{{ session('success') }}</div>
@endif

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-2 border">#</th>
            <th class="p-2 border">Nama</th>
            <th class="p-2 border">Email</th>
            <th class="p-2 border">Role</th>
            <th class="p-2 border">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td class="p-2 border">{{ $loop->iteration }}</td>
            <td class="p-2 border">{{ $user->name }}</td>
            <td class="p-2 border">{{ $user->email }}</td>
            <td class="p-2 border">{{ $user->role }}</td>
            <td class="p-2 border">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Hapus user ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
