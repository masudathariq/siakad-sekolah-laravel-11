<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('gurus', function (Blueprint $table) {

        // 1. Status Kepegawaian
        $table->enum('status_kepegawaian', ['GTY', 'GTTY'])
              ->after('id_guru');

        // 2. Pendidikan
        $table->enum('pendidikan', [
            'SMA', 'D I', 'D II', 'D III', 'D IV', 'S1', 'S2', 'S3'
        ])->after('pendidikan_terakhir');

        $table->string('jurusan')->nullable()->after('pendidikan');

        // 3. Sertifikasi
        $table->enum('status_sertifikasi', [
            'belum', 'sertifikasi', 'ppg'
        ])->default('belum')->after('jurusan');

        // kolom lama tidak dipakai lagi
        $table->dropColumn('ditugaskan_sebagai');
        $table->dropColumn('pendidikan_terakhir');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('gurus', function (Blueprint $table) {
        $table->string('pendidikan_terakhir');
        $table->string('ditugaskan_sebagai');

        $table->dropColumn([
            'status_kepegawaian',
            'pendidikan',
            'jurusan',
            'status_sertifikasi'
        ]);
    });
}

};
