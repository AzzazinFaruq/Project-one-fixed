<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penduduk>
 */
class PendudukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomer_kk' => fake(),
            'nik'=>fake(),
            'nama'=>fake(),
            'tmp_lhr'=>fake(),
            'tgl_lhr'=>fake(),
            'kelamin'=>fake(),
            'stat_kawin'=>fake(),
            'hub_kel'=>fake(),
            'warga_neg'=>fake(),
            'agama'=>fake(),
            'pendidikan'=>fake(),
            'pekerjaan'=>fake(),
            'ayah'=>fake(),
            'ibu'=>fake(),
            'kepala_kel' =>fake(),
            'no_hp' =>fake(),
            'domisili'=> fake(),
            'stat' =>fake()
        ];
    }
}
