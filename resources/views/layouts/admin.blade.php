<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Admin') | SIAKAD MTs MUSATA</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            scroll-behavior: smooth;
        }

        /* Custom Scrollbar untuk Sidebar */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #3b82f6; }

        [x-cloak] { display: none !important; }

        /* Sidebar Glassmorphism Style */
        .sidebar-gradient {
            background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
        }

        .nav-item-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Active State Animation */
        .active-glow {
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2);
        }
    </style>
</head>

<body class="bg-[#F8FAFC] text-slate-700 antialiased overflow-x-hidden">

<div class="flex min-h-screen relative">
<aside class="w-64 sidebar-gradient border-r border-slate-200 flex flex-col sticky top-0 h-screen z-40">
    
    <div class="p-6">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 bg-blue-600 rounded-xl shadow-lg shadow-blue-100 flex items-center justify-center text-white font-black text-xl">
                M
            </div>
            <div>
                <h1 class="text-sm font-black text-slate-800 leading-none uppercase tracking-tighter">MUSATA</h1>
                <p class="text-[8px] font-bold text-blue-500 uppercase tracking-widest">Siakad TU</p>
            </div>
        </a>
    </div>

    <nav id="sidebar-nav" class="flex-1 px-4 space-y-6 overflow-y-auto custom-scrollbar">
        
        @php
            $base   = 'nav-item-transition flex items-center gap-3 px-4 py-2.5 rounded-xl text-[10px] font-bold uppercase tracking-wide';
            $active = 'bg-blue-600 text-white shadow-md shadow-blue-200';
            $normal = 'text-slate-500 hover:bg-slate-50 hover:text-blue-600';
        @endphp

        <div class="space-y-1">
            <label class="px-4 text-[9px] font-black text-slate-300 uppercase tracking-[0.2em]">Utama</label>
            <a href="{{ route('admin.dashboard') }}" class="{{ $base }} {{ request()->routeIs('admin.dashboard*') ? $active : $normal }}">
                Dashboard
            </a>
        </div>

        <div class="space-y-1">
            <label class="px-4 text-[9px] font-black text-slate-300 uppercase tracking-[0.2em]">Akademik</label>
            <a href="{{ route('admin.users.index') }}" class="{{ $base }} {{ request()->routeIs('admin.user*') ? $active : $normal }}">User</a>
            <a href="{{ route('admin.siswa.index') }}" class="{{ $base }} {{ request()->routeIs('admin.siswa*') ? $active : $normal }}">Siswa</a>
            <a href="{{ route('admin.guru.index') }}" class="{{ $base }} {{ request()->routeIs('admin.guru*') ? $active : $normal }}">Pengajar</a>
            <a href="{{ route('admin.rombel.index') }}" class="{{ $base }} {{ request()->routeIs('admin.rombel*') ? $active : $normal }}">Rombel</a>
            <a href="{{ route('admin.tahun-ajaran.index') }}" class="{{ $base }} {{ request()->routeIs('admin.tahun-ajaran*') ? $active : $normal }}">Tahun Ajaran</a>
        </div>

        <div class="space-y-1">
            <label class="px-4 text-[9px] font-black text-slate-300 uppercase tracking-[0.2em]">Laporan</label>
            <a href="{{ route('admin.absen.index') }}" class="{{ $base }} {{ request()->routeIs('admin.absen*') ? $active : $normal }}">Absensi</a>
            <a href="{{ route('admin.cetak_daftarhadir_siswa.form') }}" class="{{ $base }} {{ request()->routeIs('admin.cetak_daftarhadir_siswa.form') ? $active : $normal }}">Hadir Siswa</a>
            <a href="{{ route('admin.guru.cetak_daftarhadir.form') }}" class="{{ $base }} {{ request()->routeIs('admin.guru.cetak_daftarhadir.form') ? $active : $normal }}">Hadir Guru</a>
            <a href="{{ route('admin.alumni.index') }}" class="{{ $base }} {{ request()->routeIs('admin.alumni*') ? $active : $normal }}">Alumni</a>
        </div>

        <div class="space-y-1">
            <label class="px-4 text-[9px] font-black text-slate-300 uppercase tracking-[0.2em]">Persuratan</label>
            <a href="{{ route('admin.surat-masuk.index') }}" class="{{ $base }} {{ request()->routeIs('admin.surat-masuk*') ? $active : $normal }}">Surat Masuk</a>
            <a href="{{ route('admin.surat-keluar.index') }}" class="{{ $base }} {{ request()->routeIs('admin.surat-keluar*') ? $active : $normal }}">Surat Keluar</a>
        </div>
    </nav>

    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
        <div class="flex items-center justify-between mb-3 px-2">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                <span class="text-[10px] font-bold text-slate-600 uppercase">{{ Auth::user()->name ?? 'Admin' }}</span>
            </div>
        </div>
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); logoutConfirm();"
           class="flex items-center justify-center gap-2 w-full py-2 bg-white border border-red-100 text-red-500 rounded-lg text-[10px] font-black uppercase tracking-tighter hover:bg-red-50 transition-colors">
            Keluar Sistem
        </a>
    </div>
</aside>

    <div class="flex-1 flex flex-col min-w-0">

        <header class="bg-white/80 backdrop-blur-md border-b border-slate-100 px-10 py-5 sticky top-0 z-30 flex justify-between items-center">
            <div>
                <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">
                    <span>Admin</span>
                    <span>/</span>
                    <span class="text-blue-600">@yield('page-title','Dashboard')</span>
                </nav>
                <h2 class="text-xl font-black text-slate-800 italic uppercase leading-none">Management Panel</h2>
            </div>

            <div class="hidden md:flex items-center gap-6">
                <div class="text-right">
    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Hari ini</p>
    <p class="text-xs font-black text-slate-700 italic uppercase">
        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
    </p>
    <p id="clock" class="text-xs font-black text-slate-700 italic uppercase mt-1"></p>
</div>
            </div>
        </header>

        <main class="flex-1 p-10">
            @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '<span class="text-sm font-black uppercase tracking-widest italic">BERHASIL!</span>',
                    html: '<span class="text-xs font-bold text-slate-500 uppercase">{{ session("success") }}</span>',
                    timer: 2500,
                    showConfirmButton: false,
                    customClass: { popup: 'rounded-[2rem]' }
                });
            </script>
            @endif

            @yield('content')
        </main>

        <footer class="px-10 py-8 border-t border-slate-100 bg-white/50 text-center md:text-left">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                    &copy; {{ date('Y') }} SIAKAD MTs MUSATA
                </p>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">
                    Developed by <span class="text-slate-600">Mas'ud Athorik Akbar, A.Md.Kom</span>
                </p>
            </div>
        </footer>
    </div>
</div>

<script>
    /**
     * Fitur 1: Simpan Posisi Scroll Sidebar
     * Agar saat pindah halaman, sidebar tidak balik ke atas
     */
    document.addEventListener("DOMContentLoaded", function() {
        const sidebarNav = document.getElementById("sidebar-nav");
        
        // Restore posisi scroll dari localStorage
        const savedScrollPos = localStorage.getItem('sidebarScrollPos');
        if (savedScrollPos) {
            sidebarNav.scrollTop = savedScrollPos;
        }

        // Simpan posisi scroll saat di-scroll atau diklik
        sidebarNav.addEventListener("scroll", function() {
            localStorage.setItem('sidebarScrollPos', sidebarNav.scrollTop);
        });

        // Pastikan link aktif terlihat
        const activeLink = sidebarNav.querySelector('.bg-gradient-to-r');
        if (activeLink) {
            activeLink.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    });

    /**
     * Fitur 2: Konfirmasi Logout (SweetAlert)
     */
    function logoutConfirm() {
        Swal.fire({
            title: 'KELUAR SISTEM?',
            text: "Anda harus login kembali untuk mengakses data.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'YA, KELUAR',
            cancelButtonText: 'BATAL',
            customClass: { popup: 'rounded-[2rem]' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }

    /**
     * Fitur 3: Global Delete Confirmation
     */
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.form-hapus').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'HAPUS DATA?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'YA, HAPUS',
                    cancelButtonText: 'BATAL',
                    customClass: { popup: 'rounded-[2rem]' }
                }).then(result => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    });
</script>
// jam 
<script>
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('clock').textContent = hours + ':' + minutes + ':' + seconds;
    }

    updateClock(); // jalankan langsung
    setInterval(updateClock, 1000); // update setiap detik
</script>
</body>
</html>