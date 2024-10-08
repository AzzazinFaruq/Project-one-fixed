<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\keluarga;
use App\Models\User;
use App\Http\Controllers\keluargaCon;
use App\Http\Controllers\PendudukCon;

class universalCon extends Controller
{

    public function dataCount(Request $request){
        $role =$request->user()->level;
        $penduduk;
        $keluarga;
        if ($role=='enum') {

            $id = $request->user()->id;
            $penduduk= Penduduk::where('user_id',$id)->count();
            $keluarga= keluarga::where('user_id',$id)->count();
        }
        else if($role=='admin'||$role=='superAdmin'){
            $penduduk= Penduduk::count();
            $keluarga= keluarga::count();
        }
     return ([
        'penduduk'=>$penduduk,
        'keluarga'=>$keluarga
     ]);
    }
    public function aliveCount(Request $request){
        $role =$request->user()->level;
        $alivepen;
        $nopen;
        if ($role=='enum') {
            $id = $request->user()->id;
            $alivepen= Penduduk::where('user_id',$id)->where('stat', 1)->count();
            $nopen= Penduduk::where('user_id',$id)->where('stat', 2)->count();
        }
        else if($role=='admin'||$role=='superAdmin'){
        $alivepen= Penduduk::where('stat', 1)->count();
        $nopen= Penduduk::where('stat', 2)->count();
        }
        // $nokel= keluarga::where('status', 2)->count();
        // $aktiftot= $alivepen + $alivekel;
        // $inaktiftot= $nopen + $nokel;
     return ([

            'aktif'=>$alivepen,
            'inaktif'=>$nopen

     ]);
    }
    public function marryCount(Request $request){
        $role =$request->user()->level;
        $belum;
        $kawin;
        $ceraihidup;
        $ceraimati;
        if ($role=='enum') {
            $id = $request->user()->id;
            $belum= Penduduk::where('user_id',$id)->where('stat_kawin', 1)->count();
            $kawin= Penduduk::where('user_id',$id)->where('stat_kawin', 2)->count();
            $ceraihidup= Penduduk::where('user_id',$id)->where('stat_kawin', 3)->count();
            $ceraimati= Penduduk::where('user_id',$id)->where('stat_kawin', 4)->count();
        }
        else if($role=='admin'||$role=='superAdmin'){
            $belum= Penduduk::where('stat_kawin', 1)->count();
            $kawin= Penduduk::where('stat_kawin', 2)->count();
            $ceraihidup= Penduduk::where('stat_kawin', 3)->count();
            $ceraimati= Penduduk::where('stat_kawin', 4)->count();
        }
     return response()->json([
        'data'=>[
            $belum,
            $kawin,
            $ceraihidup,
            $ceraimati
        ]
     ]);
    }
    public function genderCount(Request $request){
        $role =$request->user()->level;
        $belum;
        $kawin;
        if ($role=='enum') {
            $id = $request->user()->id;
            $belum= Penduduk::where('user_id',$id)->where('kelamin', 1)->count();
            $kawin= Penduduk::where('user_id',$id)->where('kelamin', 2)->count();
        }
        else if($role=='admin'||$role=='superAdmin') {
            $belum= Penduduk::where('kelamin', 1)->count();
            $kawin= Penduduk::where('kelamin', 2)->count();
        }
     return response()->json([
        'data'=>[
            $belum,
            $kawin,
        ]
     ]);
    }
    public function rangeData(Request $request){
        $role =$request->user()->level;
        $belum;
        $kawin;
        $year = $request->input('year');
        $month = $request->input('month');
        $limit;
        $dataPerDay = [];
        if($month==2 && $year%4==0){
            $limit=29;
        }
        else if($month==2 && $year%4==1){
            $limit=28;
        }
        else if ($month%2==1) {
            $limit=31;
        }
        else if($month%2==0){
            $limit=30;
        }
             if ($role=='enum') {
            $id = $request->user()->id;
            for ($day = 1; $day <= $limit; $day++) {
                $records = Penduduk::whereYear('created_at', $year)
                ->where('user_id',$id)
                ->whereMonth('created_at', $month)
                ->whereDay('created_at', $day)
                ->count();

            $dataPerDay []= $records;
            }
            }
            else if($role=='admin'||$role=='superAdmin'){
                for ($day = 1; $day <= $limit; $day++) {
                    $records = Penduduk::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereDay('created_at', $day)
                    ->count();

                $dataPerDay []= $records;
                }
            }


        return response()->json([
            'data'=>
                $dataPerDay

        ]);

    }

    public function AllData(Request $request){

        $kelcon= new keluargaCon();
        $pencon= new PendudukCon();

        $Jumlah = $this->dataCount($request);
        $status = $this->aliveCount($request);
        // $lastkel = $kelcon->latestkel($request);
        // $lastpen = $pencon->latest($request);

        return response()->json([

            "jumlah" => $Jumlah,
            'Status' => $status,
            
        ]);
    }

}
