<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;
use App\Http\Resources\PendudukRes;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class PendudukCon extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getPenduduk(Request $request)
    {
        $tampil=$request->input('item');
        $total= Penduduk::count();
        $role =$request->user()->level;
        $datas;
        if ($role=='enum') {
            $id = $request->user()->id;
            $total= Penduduk::where('user_id',$id)->count();
            $datas = Penduduk::where('user_id',$id)->with('keluarga','user')->paginate($tampil);
        }
        else if($role=='admin'||$role=='superAdmin'){
            $datas = Penduduk::with('keluarga','user')->paginate($tampil);
        }
              $hasils= $datas->getCollection()->reduce(
                function ($items, $data){

                    $agama=penduduk::agama($data->agama);
                    $hub=penduduk::hub_kel($data->hub_kel);
                    $stat_kwn=penduduk::stat_kawin($data->stat_kawin);
                    $kelamin=penduduk::kelamin($data->kelamin);
                    $pendidikan=penduduk::pendidikan($data->pendidikan);
                    $pekerjaan=penduduk::pekerjaan($data->pekerjaan);
                    $stat=penduduk::stat($data->stat);
                    $warga=penduduk::warga_neg($data->warga_neg);


                    $items[] = [
                        'id'=>$data->id,
                        'kels_id'=>$data->kels_id,
                        'nomer_kk'=>$data->keluarga->no_kk,
                        'nik' =>$data->nik,
                        'nama'=>$data->nama,
                        'tmp_lhr'=>$data->tmp_lhr,
                        'tgl_lhr'=>$data->tgl_lhr,
                        'kelamin'=>$kelamin,
                        'stat_kawin'=>$stat_kwn,
                        'hub_kel'=>$hub,
                        'warga_neg'=>$warga,
                        'agama' => $agama,
                        'pendidikan'=>$pendidikan,
                        'pekerjaan'=>$pekerjaan,
                        'ayah'=>$data->ayah,
                        'ibu'=>$data->ibu,
                        'kepala_kel'=>$data->keluarga->kk_nama,
                        'no_hp'=>$data->no_hp,
                        'domisili'=>$data->domisili,
                        'stat' =>$stat,
                        'user_id'=>$data->user->name
                    ];
                    return $items;
                },
            );
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = $tampil;
            $currentItems = array_slice($hasils, ($currentPage - 1) * $perPage, $perPage);
            $paginatedItems = new LengthAwarePaginator($hasils, $total , $perPage);


            // $result = [
            //     'data' => $hasill->items(),
            //     'pagination' => [
            //         'current_page' => $posts->currentPage(),
            //         'per_page' => $posts->perPage(),
            //         'total' => $posts->total(),
            //         'last_page' => $posts->lastPage(),
            //         'next_page_url' => $posts->nextPageUrl(),
            //         'prev_page_url' => $posts->previousPageUrl(),
            //         'first_page_url' => $posts->url(1),
            //         'last_page_url' => $posts->url($posts->lastPage()),
            //     ],
            //     'total_word_count' => $totalWordCount,
            // ];

// return $posts;
        return response()->json([
            'success' => true,
            'data' => $paginatedItems
        ], 200);

    }
    public function getbyID($id){
        $dt= Penduduk::where('id',$id)->get();
        return response()->json([
            'data' => $dt,
        ], 200);
    }
    public function latest(Request $request)
    {
        $role =$request->user()->level;
        $datas;
        if ($role=='enum') {
            $id = $request->user()->id;
            $datas = Penduduk::where('user_id',$id)->latest()->take(5)->get();
        }
        else if($role=='admin'||$role=='superAdmin'){
            $datas = Penduduk::latest()->take(5)->get();
        }
        $hasil = $datas->reduce(
            function ($items, $data){

                $agama=penduduk::agama($data->agama);
                $hub=penduduk::hub_kel($data->hub_kel);
                $stat_kwn=penduduk::stat_kawin($data->stat_kawin);
                $kelamin=penduduk::kelamin($data->kelamin);
                $pendidikan=penduduk::pendidikan($data->pendidikan);
                $pekerjaan=penduduk::pekerjaan($data->pekerjaan);
                $stat=penduduk::stat($data->stat);
                $warga=penduduk::warga_neg($data->warga_neg);


                $items[] = [
                    'id'=>$data->id,
                    'kk'=>$data->keluarga->no_kk.' / '.$data->keluarga->kk_nama,
                    'nik' =>$data->nik,
                    'nama'=>$data->nama,
                    'kepala_kel'=>$data->keluarga->kk_nama,
                    'status' =>$stat,
                    'user_id'=>$data->user->name

                ];
                return $items;
            }, []
        );


    return response()->json($hasil);
    }
    public function showPenduduk($id)
    {
        $dt_produk = Penduduk::where('id',$id)->get();

        $hasil = Penduduk::where('id',$id)->get()->reduce(
            function ($items, $data){

                $agama=penduduk::agama($data->agama);
                $hub=penduduk::hub_kel($data->hub_kel);
                $stat_kwn=penduduk::stat_kawin($data->stat_kawin);
                $kelamin=penduduk::kelamin($data->kelamin);
                $pendidikan=penduduk::pendidikan($data->pendidikan);
                $pekerjaan=penduduk::pekerjaan($data->pekerjaan);
                $stat=penduduk::stat($data->stat);
                $warga=penduduk::warga_neg($data->warga_neg);


                $items[] = [
                    'id'=>$data->id,
                    'nomer_kk'=>$data->keluarga->no_kk,
                    'nik' =>$data->nik,
                    'nama'=>$data->nama,
                    'tmp_lhr'=>$data->tmp_lhr,
                    'tgl_lhr'=>$data->tgl_lhr,
                    'kelamin'=>$kelamin,
                    'stat_kawin'=>$stat_kwn,
                    'hub_kel'=>$hub,
                    'warga_neg'=>$warga,
                    'agama' => $agama,
                    'pendidikan'=>$pendidikan,
                    'pekerjaan'=>$pekerjaan,
                    'ayah'=>$data->ayah,
                    'ibu'=>$data->ibu,
                    'kepala_kel'=>$data->keluarga->kk_nama,
                    'no_hp'=>$data->no_hp,
                    'domisili'=>$data->domisili,
                    'stat' =>$stat,
                    'user_id'=>$data->user->name

                ];
                return $items;
            }, []
        );


    return response()->json([
        'data' => $hasil,
    ], 200);


        return response()->json($dt_produk);
    }
    public function addPenduduk(Request $req){

        $validator= Validator::make($req->all(),[
            'kels_id'=>'required',
            'nik'=>'required',
            'nama'=>'required',
            'tmp_lhr'=>'required',
            'tgl_lhr'=>'required',
            'kelamin'=>'required',
            'stat_kawin'=>'required',
            'hub_kel'=>'required',
            'warga_neg'=>'required',
            'agama'=>'required',
            'pendidikan'=>'required',
            'pekerjaan'=>'required',
            'ayah'=>'required',
            'ibu'=>'required',
            'no_hp'=>'required',
            'domisili'=>'required',
            'stat'=>'required',
            'user_id'=>'required'


        ]);
        if ($validator->fails()) {
            return response()->json(['valid'=>false,'massage'=>'pastikan form sudah terisi dengan benar']);
        }
        $save=Penduduk::create([
            'kels_id'=>$req->get('kels_id'),
            'nik'=>$req->get('nik'),
            'nama'=>$req->get('nama'),
            'tmp_lhr'=>$req->get('tmp_lhr'),
            'tgl_lhr'=>$req->get('tgl_lhr'),
            'kelamin'=>$req->get('kelamin'),
            'stat_kawin'=>$req->get("stat_kawin"),
            'hub_kel'=>$req->get('hub_kel'),
            'warga_neg'=>$req->get('warga_neg'),
            'agama'=>$req->get('agama'),
            'pendidikan'=>$req->get('pendidikan'),
            'pekerjaan'=>$req->get('pekerjaan'),
            'ayah'=>$req->get('ayah'),
            'ibu'=>$req->get('ibu'),
            'no_hp'=>$req->get('no_hp'),
            'domisili'=>$req->get('domisili'),
            'stat'=>$req->get('stat'),
            'user_id'=>$req->get('user_id')


        ]);

        if ($save) {
            return response()->json(['valid'=>true,'massage'=>'sukses menambah Penduduk']);
        }
        else{
            return response()->json(['valid'=>false,'massage'=>'gagal menambah Penduduk']);
        }

    }

    public function updatePenduduk(Request $req, $id){

        $validator=Validator::make($req->all(),[
            'kels_id'=>'required',
            'nik'=>'required',
            'nama'=>'required',
            'tmp_lhr'=>'required',
            'tgl_lhr'=>'required',
            'kelamin'=>'required',
            'stat_kawin'=>'required',
            'hub_kel'=>'required',
            'warga_neg'=>'required',
            'agama'=>'required',
            'pendidikan'=>'required',
            'pekerjaan'=>'required',
            'ayah'=>'required',
            'ibu'=>'required',
            'no_hp'=>'required',
            'domisili'=>'required',
            'stat'=>'required',
            'user_id'=>'required'

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }
        $save=Penduduk::where('id', $id)->update($req->all());
        if ($save) {
            return response()->json(['status'=>true,'massage'=>'sukses edit penduduk']);
        }
        else{
            return response()->json(['status'=>false,'massage'=>'gagal edit penduduk']);
        }

    }
    public function destroy($id)
    {
        $penduduk = Penduduk::find($id);

        if ($penduduk) {
            $penduduk->delete();
            return response()->json(['message' => 'Data penduduk berhasil dihapus.'], 200);
        } else {
            return response()->json(['message' => 'Data penduduk tidak ditemukan.'], 404);
        }
    }
}
