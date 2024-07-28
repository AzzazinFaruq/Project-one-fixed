<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_kels', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('no_kk');
            $table->bigInteger('kk_nik');
            $table->string('kk_nama');
            $table->string('alamat');
            $table->string("rt",10);
            $table->string("rw",10);
            $table->string("kode_pos",10);
            $table->tinyInteger('status');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_kels');
    }
};
