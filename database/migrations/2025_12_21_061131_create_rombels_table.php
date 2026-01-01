<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rombels', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tahun_ajaran_id')
                  ->constrained('tahun_ajarans')
                  ->cascadeOnDelete();

            $table->foreignId('tingkat_id')
                  ->constrained('tingkats')
                  ->cascadeOnDelete();

            $table->string('kode_kelas', 5); // A, B, C
            $table->string('nama_kelas')->nullable();

            $table->timestamps();

            // mencegah kelas dobel
            $table->unique([
                'tahun_ajaran_id',
                'tingkat_id',
                'kode_kelas'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rombels');
    }
};
