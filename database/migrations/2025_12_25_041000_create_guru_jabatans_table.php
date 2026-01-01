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
        Schema::create('guru_jabatans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('guru_id')->constrained('gurus')->cascadeOnDelete();

    $table->enum('jabatan', [
        'kepala_madrasah',
        'wakil_kepala',
        'kepala_tu',
        'staff_tu',
        'bendahara',
        'guru_mapel'
    ]);

    // khusus wakil
    $table->string('bidang')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_jabatans');
    }
};
