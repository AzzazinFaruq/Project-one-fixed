<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@user.com',
            'level'=> 'superAdmin',
            'password' => Hash::make('password'),
        ]);
        \App\Models\Penduduk::factory(10)->create([
            'nomer_kk' => Str::random(10),
            'nik'=>Str::random(10),
            'nama'=>Str::random(10),
            'tmp_lhr'=>Str::random(10),
            'tgl_lhr'=>'2022-9-12',
            'kelamin'=>1,
            'stat_kawin'=>1,
            'hub_kel'=>1,
            'warga_neg'=>1,
            'agama'=>1,
            'pendidikan'=>1,
            'pekerjaan'=>1,
            'ayah'=>1,
            'ibu'=>1,
            'kepala_kel' =>Str::random(10),
            'no_hp' =>"00112233",
            'domisili'=> Str::random(10),
            'stat' =>1
            ]);

    }
}
