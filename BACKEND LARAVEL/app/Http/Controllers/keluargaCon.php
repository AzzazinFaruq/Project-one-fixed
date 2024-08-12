<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\keluarga;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
class keluargaCon extends Controller
{
    public function latest(Request $request){
        $role =$request->user()->level;
        $datas;
        if ($role=='enum') {
            $id = $request->user()->id;
            $datas = keluarga::where('user_id',$id)->latest()->with('user')->take(5)->get();
        }
        else if($role=='admin'||$role=='superAdmin'){
            $datas = keluarga::latest()->with('user')->take(5)->get();
        }
        $hasils= $datas->reduce(
            function ($items, $data){
                $stat=keluarga::stat($data->status);
                $items[] = [
                'id'=>$data->id,
                'kk'=>$data->no_kk,
                'nik'=>$data->kk_nik,
                'status'=>$stat,
                'nama'=>$data->kk_nama,
                'user_id'=>$data->user->name,
                ];
                return $items;
            },
        );


        return response()->json($hasils);

    }
    public function index(Request $request){
        $tampil=$request->input('item');
        $total= keluarga::count();
        $role =$request->user()->level;
        $datas;
        if ($role=='enum') {
            $id = $request->user()->id;
            $total= keluarga::where('user_id',$id)->count();
            $datas = keluarga::where('user_id',$id)->paginate($tampil);
        }
        else if($role=='admin'||$role=='superAdmin'){
            $datas = keluarga::with('user')->paginate($tampil);
        }

        $hasils= $datas->reduce(
            function ($items, $data){
                $stat=keluarga::stat($data->status);
                $items[] = [
                'id'=>$data->id,
                'no_kk'=>$data->no_kk,
                'kk_nik'=>$data->kk_nik,
                'kk_nama'=>$data->kk_nama,
                'alamat'=>$data->alamat,
                'rt'=>$data->rt,
                'rw'=>$data->rw,
                'kode_pos'=>$data->kode_pos,
                'status'=>$stat,
                'user_id'=>$data->user->name,
                ];
                return $items;
            },
        );
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = $tampil;
        $currentItems = array_slice($hasils, ($currentPage - 1) * $perPage, $perPage);
        $paginatedItems = new LengthAwarePaginator($hasils, $total , $perPage);


        return response()->json($paginatedItems);

    }

    public function getbyID($id){
        $dt= keluarga::where('id',$id)->get();

        $hasils= $dt->reduce(
            function ($items, $data){
                $stat=keluarga::stat($data->status);
                $items[] = [
               'id'=>$data->id,
                'no_kk'=>$data->no_kk,
                'kk_nik'=>$data->kk_nik,
                'kk_nama'=>$data->kk_nama,
                'alamat'=>$data->alamat,
                'rt'=>$data->rt,
                'rw'=>$data->rw,
                'kode_pos'=>$data->kode_pos,
                'status'=>$stat,
                'user_id'=>$data->user->id,
                'user_name'=>$data->user->name
                ];
                return $items;
            },
        );



        return response()->json($hasils);
    }
    public function byID($id){
        $dt= keluarga::where('id',$id)->get();

        return response()->json([
            'data' => $dt,
        ], 200);
    }
    public function get(Request $request){
        $role =$request->user()->level;
        $datas;
        if ($role=='enum') {
            $id = $request->user()->id;
            $datas = keluarga::where('user_id',$id)->with('user')->get();
        }
        else {
            $datas = keluarga::with('user')->get();
        }

        $dt= keluarga::get();
        return response()->json([
            'data' => $datas,
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
            return response()->json(['valid'=>true,'massage'=>'sukses menambah Keluarga']);
        }
        else{
            return response()->json(['valid'=>false,'massage'=>'gagal menambah Keluarga']);
        }

    }
    public function destroy($id)
    {
        $penduduk = keluarga::find($id);

        if ($penduduk) {
            $penduduk->delete();
            return response()->json(['message' => 'Data keluarga berhasil dihapus.'], 200);
        } else {
            return response()->json(['message' => 'Data keluarga tidak ditemukan.'], 404);
        }
    }
    public function update(Request $req, $id){

        $validator=Validator::make($req->all(),[
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
            return response()->json($validator->errors()->toJson());
        }
        $save=keluarga::where('id', $id)->update($req->all());
        if ($save) {
            return response()->json(['status'=>true,'massage'=>'sukses edit keluarga']);
        }
        else{
            return response()->json(['status'=>false,'massage'=>'gagal edit keluarga']);
        }
    }



}

