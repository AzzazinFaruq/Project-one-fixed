<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\keluarga;

class universalCon extends Controller
{
    public function dataCount(){
        $penduduk= Penduduk::count();
        $keluarga= keluarga::count();

     return response()->json([
        'penduduk'=>$penduduk,
        'keluarga'=>$keluarga
     ]);
    }
    public function aliveCount(){

        $alivepen= Penduduk::where('stat', 1)->count();
        $alivekel= keluarga::where('status', 1)->count();
        $nopen= Penduduk::where('stat', 2)->count();
        $nokel= keluarga::where('status', 2)->count();

        $aktiftot= $alivepen + $alivekel;
        $inaktiftot= $nopen + $nokel;

     return response()->json([
        'data'=>[
            'aktif'=>$alivepen,
            'inaktif'=>$alivepen
        ]
     ]);
    }
}
