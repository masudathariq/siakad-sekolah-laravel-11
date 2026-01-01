<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('siswas', function (Blueprint $table) {
        $table->enum('jenis_rombel', ['reguler', 'pondok'])
              ->default('reguler')
              ->after('jenis_kelamin');
    });
}

public function down()
{
    Schema::table('siswas', function (Blueprint $table) {
        $table->dropColumn('jenis_rombel');
    });
}

};
