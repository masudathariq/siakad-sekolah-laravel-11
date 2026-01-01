<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tingkats', function (Blueprint $table) {
            $table->id();
            $table->string('nama');   // VII, VIII, IX
            $table->integer('urutan'); // 1, 2, 3
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tingkats');
    }
};
