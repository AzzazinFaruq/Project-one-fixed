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
        Schema::create('data_idv', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kels_id')->references('id')->on('data_kels');
            $table->string("nik",20);
            $table->string("nama");
            $table->string("tmp_lhr");
            $table->date("tgl_lhr")->default("2000-01-01");
            $table->tinyInteger('kelamin')->null();
            $table->tinyInteger('stat_kawin')->null();
            $table->tinyInteger('hub_kel')->null();
            $table->tinyInteger('warga_neg')->null();
            $table->tinyInteger('agama')->null();
            $table->tinyInteger('pendidikan')->null();
            $table->tinyInteger('pekerjaan')->null();
            $table->string('ayah')->null();
            $table->string('ibu')->null();
            $table->string('no_hp',15)->null();
            $table->longText('domisili')->null();
            $table->tinyInteger('stat')->default(0);
            $table->foreignId('user_id')->references('id')->on('users');
            $table->timestamps();

            // $table->id();
            // $table->integer("id_user");
            // $table->string("nomer_kk",20);
            // $table->string("nik",20);
            // $table->string("nama");
            // $table->string("tmp_lhr");
            // $table->date("tgl_lhr")->default("2000-01-01");
            // $table->tinyInteger('kelamin')->null();
            // $table->tinyInteger('stat_kawin')->null();
            // $table->tinyInteger('hub_kel')->null();
            // $table->tinyInteger('warga_neg')->null();
            // $table->tinyInteger('agama')->null();
            // $table->tinyInteger('pendidikan')->null();
            // $table->tinyInteger('pekerjaan')->null();
            // $table->string('ayah')->null();
            // $table->string('ibu')->null();
            // $table->string('kepala_kel')->null();
            // $table->string('no_hp',15)->null();
            // $table->tinyInteger('domisili')->default(0);
            // $table->tinyInteger('stat')->default(0);
            // $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
