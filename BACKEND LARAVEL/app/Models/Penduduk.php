<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;
    protected $table="data_idv";
    protected $primarykey="id";
    protected $fillable = [
        'nomer_kk',
        'nik',
        'nama',
        'tmp_lhr',
        'tgl_lhr',
        'kelamin',
        'stat_kawin',
        'hub_kel',
        'warga_neg',
        'agama',
        'pendidikan',
        'pekerjaan',
        'ayah',
        'ibu',
        'kepala_kel',
        'no_hp',
        'domisili',
        'stat'

    ];
    public $timestamps=true;
}
