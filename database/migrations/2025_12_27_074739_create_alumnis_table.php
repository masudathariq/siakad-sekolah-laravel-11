<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumnis', function (Blueprint $table) {
            $table->id();
            $table->string('nisn');
            $table->string('nis');
            $table->string('nama_siswa');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('ayah')->nullable();
            $table->string('ibu')->nullable();
            $table->string('wali')->nullable();
            $table->text('alamat')->nullable();
            $table->string('sekolah_asal')->nullable();
            $table->unsignedBigInteger('rombel_id')->nullable();
            $table->unsignedBigInteger('tahun_ajaran_id'); // tahun lulus
            $table->timestamps();

            $table->foreign('rombel_id')->references('id')->on('rombels')->nullOnDelete();
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajarans')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
