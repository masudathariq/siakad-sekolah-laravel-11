<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Karyawan Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex">

    <!-- Sidebar Karyawan -->
    <div class="w-64 bg-blue-800 text-white min-h-screen">
        <div class="p-6 text-2xl font-bold">Karyawan Panel</div>

        <!-- Selamat datang nama user -->
        <div class="px-6 py-2 mt-2 bg-blue-700 rounded">
            Selamat datang, {{ Auth::user()->name }}
        </div>

        <nav class="mt-6">
            <a href="{{ route('karyawan.dashboard') }}" class="block py-2 px-6 hover:bg-blue-700">Dashboard</a>
            <a href="#" class="block py-2 px-6 hover:bg-blue-700">Absensi</a>
            <a href="#" class="block py-2 px-6 hover:bg-blue-700">Profile</a>
            <a href="{{ route('logout') }}" class="block py-2 px-6 hover:bg-blue-700">Logout</a>
        </nav>
    </div>

    <div class="flex-1 p-6">
        <header class="mb-6">
            <h1 class="text-3xl font-bold">@yield('page-title')</h1>
        </header>
        <main>@yield('content')</main>
    </div>

</body>
</html>
