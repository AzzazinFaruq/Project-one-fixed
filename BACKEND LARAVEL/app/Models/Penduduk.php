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
    public $timestamps=false;
    public static function stat($key = '')
    {
        $data = config('constants.stat');
        if ( !isset($data[$key]) )
            return $data;

        return $data[$key];
    }
    public static function pekerjaan($key = '')
    {
        $data = config('constants.pekerjaan');
        if ( !isset($data[$key]) )
            return $data;

        return $data[$key];
    }
    public static function pendidikan($key = '')
    {
        $data = config('constants.pendidikan');
        if ( !isset($data[$key]) )
            return $data;

        return $data[$key];
    }
    public static function warga_neg($key = '')
    {
        $data = config('constants.warga_negara');
        if ( !isset($data[$key]) )
            return $data;

        return $data[$key];
    }
    public static function agama($key = '')
    {
        $data = config('constants.agama');
        if ( !isset($data[$key]) )
            return $data;

        return $data[$key];
    }
    public static function kelamin($key = '')
    {
        $data = config('constants.sex');
        if ( !isset($data[$key]) )
            return $data;

        return $data[$key];
    }
    public static function stat_kawin($key = '')
    {
        $data = config('constants.status_kawin');
        if ( !isset($data[$key]) )
            return $data;

        return $data[$key];
    }
    public static function hub_kel($key = '')
    {
        $data = config('constants.shdk');
        if ( !isset($data[$key]) )
            return $data;

        return $data[$key];
    }



}
