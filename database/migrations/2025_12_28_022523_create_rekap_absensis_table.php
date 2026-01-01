<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekap_absensis', function (Blueprint $table) {
            $table->id();

            // Relasi utama
            $table->string('siswa_nisn');
            $table->unsignedBigInteger('rombel_id');
            $table->unsignedBigInteger('tahun_ajaran_id');

            // Periode absensi
            $table->tinyInteger('bulan'); // 1 - 12
            $table->year('tahun');

            // Rekapan
            $table->integer('hadir')->default(0);
            $table->integer('izin')->default(0);
            $table->integer('sakit')->default(0);
            $table->integer('alpha')->default(0);
            $table->integer('bolos')->default(0);
            // --- TAMBAHKAN BARIS INI ---
            $table->integer('hari_efektif')->default(25);

            $table->timestamps();

            // ======================
            // FOREIGN KEY
            // ======================
            $table->foreign('siswa_nisn')
                  ->references('nisn')
                  ->on('siswas')
                  ->onDelete('cascade');

            $table->foreign('rombel_id')
                  ->references('id')
                  ->on('rombels')
                  ->onDelete('cascade');

            $table->foreign('tahun_ajaran_id')
                  ->references('id')
                  ->on('tahun_ajarans')
                  ->onDelete('cascade');

            // ======================
            // CEGAH DUPLIKASI
            // ======================
            $table->unique([
                'siswa_nisn',
                'rombel_id',
                'tahun_ajaran_id',
                'bulan',
                'tahun'
            ], 'rekap_absensi_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekap_absensis');
    }
};
