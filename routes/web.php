<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

/*
|--------------------------------------------------------------------------
| AUTH CONTROLLER
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\RombelController;
use App\Http\Controllers\Admin\AbsenController;
use App\Http\Controllers\Admin\SuratMasukController;
use App\Http\Controllers\Admin\SuratKeluarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\RekapAbsensiController;


/*
|--------------------------------------------------------------------------
| REDIRECT AWAL
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| ROUTE DENGAN AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ========================== ADMIN AREA ==========================
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')
        ->name('admin.')
        ->middleware(RoleMiddleware::class . ':admin')
        ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */
        Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */
        Route::resource('users', UserController::class)
            ->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | SISWA
        |--------------------------------------------------------------------------
        */
        Route::prefix('siswa')->name('siswa.')->group(function () {

        // ⚠️ Harus diletakkan paling atas
        Route::delete('/hapus-semua', [SiswaController::class, 'hapusSemua'])
            ->name('hapusSemua');

        Route::post('/import', [SiswaController::class, 'import'])->name('import');
        Route::get('/template', [SiswaController::class, 'downloadTemplate'])->name('template');

        Route::get('/',        [SiswaController::class, 'index'])->name('index');
        Route::get('/create',  [SiswaController::class, 'create'])->name('create');
        Route::post('/',       [SiswaController::class, 'store'])->name('store');
                // ✅ CETAK PDF (POST)
    Route::post('/cetak-pdf', [SiswaController::class, 'cetakPDF'])
        ->name('cetak_pdf');

        // ❗ Route dengan parameter diletakkan PALING BAWAH
        Route::get('/{nisn}',        [SiswaController::class, 'show'])->name('show');
        Route::get('/{nisn}/edit',   [SiswaController::class, 'edit'])->name('edit');
        Route::put('/{nisn}',        [SiswaController::class, 'update'])->name('update');
        Route::delete('/{nisn}',     [SiswaController::class, 'destroy'])->name('destroy');
    });

        /*
        |--------------------------------------------------------------------------
        | GURU
        |--------------------------------------------------------------------------
        */
        Route::prefix('guru')->name('guru.')->group(function () {
            Route::get('/',           [GuruController::class, 'index'])->name('index');
            Route::get('/create',     [GuruController::class, 'create'])->name('create');
            Route::post('/',          [GuruController::class, 'store'])->name('store');
            Route::get('/cetak', [GuruController::class, 'cetak'])->name('cetak');
                // FORM INPUT JUDUL DAFTAR HADIR
    Route::get('/cetak-daftarhadir', 
        [GuruController::class, 'formCetakDaftarHadir']
    )->name('cetak_daftarhadir.form');

    // PROSES CETAK PDF DAFTAR HADIR
    Route::post('/cetak-daftarhadir', [GuruController::class, 'cetakDaftarHadir'])->name('cetak_daftarhadir');
        // Cetak PDF Base64 via POST
            Route::post('/cetak-base64/{id}', [GuruController::class, 'cetakPdfBase64'])->name('cetak.base64');


            Route::get('/{id}',       [GuruController::class, 'show'])->name('show');
            Route::get('/{id}/edit',  [GuruController::class, 'edit'])->name('edit');
            Route::put('/{id}',       [GuruController::class, 'update'])->name('update');
            Route::delete('/{id}',    [GuruController::class, 'destroy'])->name('destroy');
            // Aktif / Nonaktif Guru
            Route::patch('/{id}/status', [GuruController::class, 'toggleStatus'])->name('status');
        });

        /*
        |--------------------------------------------------------------------------
        | TAHUN AJARAN
        |--------------------------------------------------------------------------
        */
        Route::resource('tahun-ajaran', TahunAjaranController::class)
            ->except(['show', 'destroy']);

 /*
|--------------------------------------------------------------------------
| ROMBEL
|--------------------------------------------------------------------------
*/

// 1️⃣ Route statis untuk cetak daftar hadir siswa
Route::get('rombel/cetak-daftarhadir-siswa', [RombelController::class, 'formCetakDaftarHadirSiswa'])
    ->name('cetak_daftarhadir_siswa.form');

Route::post('rombel/cetak-daftarhadir-siswa', [RombelController::class, 'cetakDaftarHadirSiswa'])
    ->name('cetak_daftarhadir_siswa');

// 2️⃣ Route resource rombel (CRUD utama)
Route::resource('rombel', RombelController::class);

// 3️⃣ Kelola siswa dalam rombel
Route::get('rombel/{rombel}/siswa', [RombelController::class, 'siswa'])
    ->name('rombel.siswa');

Route::post('rombel/{rombel}/siswa', [RombelController::class, 'simpanSiswa'])
    ->name('rombel.siswa.store');

Route::delete('rombel/{rombel}/siswa/{siswa}', [RombelController::class, 'keluarkanSiswa'])
    ->name('rombel.siswa.keluar');

Route::get('rombel/{rombel}/siswa/{siswa}/pindah', [RombelController::class, 'formPindahSiswa'])
    ->name('rombel.siswa.pindah');

Route::put('rombel/{rombel}/siswa/{siswa}/pindah', [RombelController::class, 'pindahSiswa'])
    ->name('rombel.siswa.pindah.store');

// 4️⃣ Naik kelas & lulus
Route::get('rombel/{rombel}/naik-kelas', [RombelController::class, 'formNaikKelas'])
    ->name('rombel.naik-kelas');

Route::post('rombel/{rombel}/naik-kelas', [RombelController::class, 'prosesNaikKelas'])
    ->name('rombel.naik-kelas.proses');

Route::post('rombel/{rombel}/luluskan', [RombelController::class, 'luluskan'])
    ->name('rombel.luluskan');

// 5️⃣ Rekap absensi
Route::get('rekap-absensi', [RekapAbsensiController::class, 'index'])
    ->name('rekap-absensi.index');

Route::post('rekap-absensi', [RekapAbsensiController::class, 'store'])
    ->name('rekap-absensi.store');

Route::post('rekap-absensi/pdf', [RekapAbsensiController::class, 'cetakPdf'])
    ->name('rekap-absensi.pdf');


        /*
        |--------------------------------------------------------------------------
        | ABSENSI
        |--------------------------------------------------------------------------
        */
        Route::get('absen', [AbsenController::class, 'index'])->name('absen.index');
        Route::post('absen/cetak', [AbsenController::class, 'cetak'])->name('absen.cetak');
        Route::get('absen/preview', [AbsenController::class, 'preview'])->name('absen.preview');

        /*
        |--------------------------------------------------------------------------
        | SURAT MASUK
        |--------------------------------------------------------------------------
        */
        Route::prefix('surat-masuk')->name('surat-masuk.')->group(function () {
            Route::get('/',        [SuratMasukController::class, 'index'])->name('index');
            Route::get('/create',  [SuratMasukController::class, 'create'])->name('create');
            Route::post('/',       [SuratMasukController::class, 'store'])->name('store');
            Route::get('/{id}',    [SuratMasukController::class, 'show'])->name('show');
            Route::get('/{id}/edit',[SuratMasukController::class, 'edit'])->name('edit');
            Route::put('/{id}',    [SuratMasukController::class, 'update'])->name('update');
            Route::delete('/{id}', [SuratMasukController::class, 'destroy'])->name('destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | SURAT KELUAR
        |--------------------------------------------------------------------------
        */
        Route::prefix('surat-keluar')->name('surat-keluar.')->group(function () {
            Route::get('/',        [SuratKeluarController::class, 'index'])->name('index');
            Route::get('/create',  [SuratKeluarController::class, 'create'])->name('create');
            Route::post('/',       [SuratKeluarController::class, 'store'])->name('store');
            Route::get('/{id}',    [SuratKeluarController::class, 'show'])->name('show');
            Route::get('/{id}/edit',[SuratKeluarController::class, 'edit'])->name('edit');
            Route::put('/{id}',    [SuratKeluarController::class, 'update'])->name('update');
            Route::delete('/{id}', [SuratKeluarController::class, 'destroy'])->name('destroy');

            // Preview PDF
            Route::get('/preview/{id}', [SuratKeluarController::class, 'previewPdf'])
                ->name('preview-pdf');
        });

        /*
        |--------------------------------------------------------------------------
        | ALUMNI
        |--------------------------------------------------------------------------
        */
        Route::get('/alumni', [AlumniController::class, 'index'])
            ->name('alumni.index');

        Route::get('/alumni/cetak', [AlumniController::class, 'cetak'])
    ->name('alumni.cetak');

        Route::post('/rombel/{rombel}/luluskan', [AlumniController::class, 'luluskan'])
            ->name('rombel.luluskan');

        });
        Route::delete('admin/alumni/{alumni}/hapus', [AlumniController::class, 'hapus'])
         ->name('admin.alumni.hapus');

         /*
        |--------------------------------------------------------------------------
        | REKAP ABSENSI
        |--------------------------------------------------------------------------
        */

    /*
    |--------------------------------------------------------------------------
    | ========================== KARYAWAN AREA ==========================
    |--------------------------------------------------------------------------
    */
    Route::get('/karyawan/dashboard', fn () => view('karyawan.dashboard'))
        ->middleware(RoleMiddleware::class . ':karyawan')
        ->name('karyawan.dashboard');

    /*
    |--------------------------------------------------------------------------
    | ROUTE DI LUAR ADMIN & KARYAWAN (CETAK / EXPORT)
    |--------------------------------------------------------------------------
    */
    Route::get('admin/rombel/{rombel}/cetak', [RombelController::class, 'cetak'])
        ->name('admin.rombel.cetak');

    Route::get('admin/rombel/{rombel}/preview', [RombelController::class, 'preview'])
        ->name('admin.rombel.preview');

    Route::get('admin/rombel/{id}/export', [RombelController::class, 'exportExcel'])
        ->name('admin.rombel.export');

    // Cetak PDF Siswa


    // Cetak & Preview Surat
    Route::get('/surat-keluar/cetak', [SuratKeluarController::class, 'cetakPdf'])
        ->name('admin.surat-keluar.cetak');

    Route::get('/surat-masuk/cetak-all', [SuratMasukController::class, 'cetakSemua'])
        ->name('admin.surat-masuk.cetak-all');

    Route::get('admin/surat-masuk/file/{id}', [SuratMasukController::class, 'lihatFile'])
        ->name('surat-masuk.lihat-file');

    Route::get('admin/surat-masuk/preview/{id}', [SuratMasukController::class, 'previewPdf'])
        ->name('surat-masuk.preview-pdf');

    Route::get('admin/surat-keluar/preview/{id}', [SuratKeluarController::class, 'previewPdf'])
        ->name('admin.surat-keluar.preview-pdf');

});
