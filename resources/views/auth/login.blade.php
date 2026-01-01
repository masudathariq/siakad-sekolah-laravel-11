<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <!-- ✅ WAJIB AGAR MOBILE FRIENDLY -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Sistem Informasi Akademik</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-700 via-blue-700 to-blue-900">

    <!-- ✅ Scroll aman di mobile -->
    <div class="min-h-screen flex flex-col lg:flex-row overflow-y-auto">

        <!-- ===================== LEFT SIDE (DESKTOP ONLY) ===================== -->
        <div class="hidden lg:flex w-1/2 relative items-center justify-center">

            <div class="absolute inset-0 bg-gradient-to-br from-indigo-800/90 to-blue-900/90"></div>
            <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_top_left,white,transparent_60%)]"></div>

            <div class="relative z-10 text-white max-w-md px-10">
                <img src="{{ asset('images/logo.png') }}"
                     class="w-28 h-28 mb-6"
                     alt="Logo Sekolah">

                <h1 class="text-3xl font-bold mb-4">
                    Sistem Informasi Akademik
                </h1>

                <p class="text-sm text-indigo-100 leading-relaxed">
                    Platform pengelolaan data akademik siswa, rombel,
                    kehadiran, dan laporan sekolah secara terintegrasi.
                </p>

                <div class="mt-6 text-sm text-indigo-200">
                    MTs Muhammadiyah 1 Natar
                </div>
            </div>
        </div>

        <!-- ===================== RIGHT SIDE (LOGIN FORM) ===================== -->
        <div class="w-full lg:w-1/2 flex items-center justify-center
                    px-4 sm:px-6 py-8">

            <div class="w-full max-w-sm bg-white rounded-2xl shadow-2xl
                        p-6 sm:p-8 relative"
                 x-data="{ show:false, loading:false }">

                <!-- Accent Bar -->
                <div class="absolute inset-x-0 top-0 h-1 rounded-t-2xl
                            bg-gradient-to-r from-indigo-500 to-emerald-400"></div>

                <!-- Mobile Logo -->
                <div class="flex justify-center mb-4 lg:hidden">
                    <img src="{{ asset('images/logo.png') }}"
                         class="w-20 h-20"
                         alt="Logo Sekolah">
                </div>

                <!-- Title -->
                <div class="text-center mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-800">
                        Login Sistem
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Masuk untuk mengakses dashboard
                    </p>
                </div>

                <!-- Error -->
                @if(session('error'))
                    <div class="mb-4 bg-red-100 text-red-700 text-sm
                                rounded-lg px-4 py-3 text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- FORM -->
                <form method="POST"
                      action="{{ route('login.post') }}"
                      @submit="loading=true"
                      class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">
                            Email
                        </label>
                        <input type="email" name="email" required
                               class="w-full rounded-lg border border-slate-300
                                      px-4 py-3 text-sm
                                      focus:ring-2 focus:ring-indigo-500
                                      focus:outline-none">
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">
                            Password
                        </label>

                        <div class="relative">
                            <input :type="show ? 'text' : 'password'"
                                   name="password"
                                   required
                                   class="w-full rounded-lg border border-slate-300
                                          px-4 py-3 pr-12 text-sm
                                          focus:ring-2 focus:ring-indigo-500
                                          focus:outline-none">

                            <button type="button"
                                    @click="show = !show"
                                    class="absolute inset-y-0 right-3
                                           text-xs font-medium text-slate-500">
                                <span x-show="!show">Show</span>
                                <span x-show="show">Hide</span>
                            </button>
                        </div>
                    </div>

                    <!-- Button -->
                    <button type="submit"
                            :disabled="loading"
                            class="w-full flex justify-center items-center gap-2
                                   bg-gradient-to-r from-indigo-600 to-blue-600
                                   text-white py-3 rounded-lg font-semibold
                                   hover:from-indigo-700 hover:to-blue-700
                                   transition shadow-md disabled:opacity-70">

                        <svg x-show="loading"
                             class="w-5 h-5 animate-spin"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"
                                    stroke-width="4" class="opacity-25"></circle>
                            <path d="M4 12a8 8 0 018-8"
                                  stroke-width="4" class="opacity-75"></path>
                        </svg>

                        <span x-text="loading ? 'Memproses...' : 'Masuk'"></span>
                    </button>
                </form>

                <!-- Footer -->
                <div class="mt-6 text-center text-xs text-slate-500">
                    © {{ date('Y') }} MTs Muhammadiyah 1 Natar
                </div>

            </div>
        </div>
    </div>

</body>
</html>
