<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rombels', function (Blueprint $table) {
            $table->enum('jenis_rombel', ['reguler', 'pondok'])
                  ->default('reguler')
                  ->after('nama_kelas'); // letak kolom baru setelah nama_kelas
        });
    }

    public function down(): void
    {
        Schema::table('rombels', function (Blueprint $table) {
            $table->dropColumn('jenis_rombel');
        });
    }
};
