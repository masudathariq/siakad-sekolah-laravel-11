<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('siswas', function (Blueprint $table) {
        $table->string('nisn')->primary(); // Primary Key
        $table->string('nis')->unique();
        $table->string('nama_siswa');
        $table->enum('jenis_kelamin', ['L', 'P']);
        $table->string('ayah')->nullable();
        $table->string('ibu')->nullable();
        $table->string('wali')->nullable();
        $table->text('alamat')->nullable();
        $table->string('sekolah_asal')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
