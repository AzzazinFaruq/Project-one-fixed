<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\keluarga;
use Illuminate\Support\Facades\Validator;

class keluargaCon extends Controller
{
    public function index(){
        $dt = keluarga::get();

        return response()->json([
            'data' => $dt
        ]);

    }

    public function getbyID($id){
        $dt= keluarga::where('id',$id)->get();

        return response()->json([
            'data' => $dt,
        ], 200);
    }

    public function addKeluarga(Request $req){

        $validator= Validator::make($req->all(),[
            'no_kk'=>'required',
            'kk_nik'=>'required',
            'kk_nama'=>'required',
            'alamat'=>'required',
            'rt'=>'required',
            'rw'=>'required',
            'kode_pos'=>'required',
            'status'=>'required',
            'user_id'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['valid'=>false,'massage'=>'pastikan form sudah terisi dengan benar']);
        }
        $save=keluarga::create([
            'no_kk'=>$req->get('no_kk'),
            'kk_nik'=>$req->get('kk_nik'),
            'kk_nama'=>$req->get('kk_nama'),
            'alamat'=>$req->get('alamat'),
            'rt'=>$req->get('rt'),
            'rw'=>$req->get('rw'),
            'kode_pos'=>$req->get('kode_pos'),
            'status'=>$req->get('status'),
            'user_id'=>$req->get('user_id'),
        ]);

        if ($save) {
            return response()->json(['valid'=>true,'massage'=>'sukses menambah Penduduk']);
        }
        else{
            return response()->json(['valid'=>false,'massage'=>'gagal menambah Penduduk']);
        }

    }
    public function destroy($id)
    {
        $penduduk = keluarga::find($id);

        if ($penduduk) {
            $penduduk->delete();
            return response()->json(['message' => 'Data penduduk berhasil dihapus.'], 200);
        } else {
            return response()->json(['message' => 'Data penduduk tidak ditemukan.'], 404);
        }
    }


}
