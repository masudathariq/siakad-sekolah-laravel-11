<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rombel_siswa', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rombel_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('siswa_nisn');
            $table->foreign('siswa_nisn')
                  ->references('nisn')
                  ->on('siswas')
                  ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['rombel_id', 'siswa_nisn']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rombel_siswa');
    }
};
