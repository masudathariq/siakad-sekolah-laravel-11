<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->date('tanggal_diterima')->nullable();
            $table->string('pengirim')->nullable();
            $table->string('perihal')->nullable();
            $table->enum('sifat', ['Biasa','Penting','Segera','Rahasia'])->default('Biasa');
            $table->string('kategori')->nullable();
            $table->string('tujuan')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('file')->nullable(); // Untuk upload PDF
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
