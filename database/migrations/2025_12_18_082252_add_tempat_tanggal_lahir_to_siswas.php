<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
public function up()
{
    Schema::table('siswas', function (Blueprint $table) {
        $table->string('tempat_lahir')->nullable()->after('nama_siswa');
        $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
    });
}


public function down()
{
    Schema::table('siswas', function (Blueprint $table) {
        $table->dropColumn(['tempat_lahir','tanggal_lahir']);
    });
}

};
