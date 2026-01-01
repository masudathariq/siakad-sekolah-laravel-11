<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->unsignedBigInteger('rombel_id')->nullable()->after('sekolah_asal');

            $table->foreign('rombel_id')
                  ->references('id')
                  ->on('rombels')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropForeign(['rombel_id']);
            $table->dropColumn('rombel_id');
        });
    }
};
