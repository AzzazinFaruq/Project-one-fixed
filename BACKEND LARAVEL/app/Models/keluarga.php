<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class keluarga extends Model
{
    use HasFactory;
    protected $table="data_kels";
    protected $primarykey="id";
    protected $fillable = [
        'no_kk',
        'kk_nik',
        'kk_nama',
        'alamat',
        'rt',
        'rw',
        'kode_pos',
        'status',
        'user_id',
    ];
}
