<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;
use App\Http\Resources\PendudukRes;
use Illuminate\Support\Facades\Validator;

class PendudukCon extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getPenduduk()
    {
        $dt=Penduduk::get();

        $datas = new Penduduk;

            $hasil = $datas->get()->reduce(
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
                        'nomer_kk'=>$data->nomer_kk,
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
                        'kepala_kel'=>$data->kepala_kel,
                        'no_hp'=>$data->no_hp,
                        'domisili'=>$data->domisili,
                        'stat' =>$stat
                    ];
                    return $items;
                }, []
            );


        return response()->json([
            'success' => true,
            // 'message' => "Data DTKS Potensi Sasaran ".$data_dinas."",
            // 'total' => count($hasil),
            'data' => $hasil,
        ], 200);

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
                    'nomer_kk'=>$data->nomer_kk,
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
                    'kepala_kel'=>$data->kepala_kel,
                    'no_hp'=>$data->no_hp,
                    'domisili'=>$data->domisili,
                    'stat' =>$stat
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
            'nomer_kk'=>'required',
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
            'kepala_kel'=>'required',
            'no_hp'=>'required',
            'domisili'=>'required',
            'stat'=>'required',


        ]);
        if ($validator->fails()) {
            return response()->json(['valid'=>false,'massage'=>'pastikan form sudah terisi dengan benar']);
        }
        $save=Penduduk::create([
            'nomer_kk'=>$req->get('nomer_kk'),
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
            'kepala_kel'=>$req->get('kepala_kel'),
            'no_hp'=>$req->get('no_hp'),
            'domisili'=>$req->get('domisili'),
            'stat'=>$req->get('stat')
        ]);

        if ($save) {
            return response()->json(['valid'=>true,'massage'=>'sukses menambah siswa']);
        }
        else{
            return response()->json(['valid'=>false,'massage'=>'gagal menambah siswa']);
        }

    }

    public function updatePenduduk(Request $req, $id){

        $validator=Validator::make($req->all(),[
            'nomer_kk' => 'required',
            'nik' => 'required',
            'nama' => 'required',
            'tmp_lhr' => 'required',
            'tgl_lhr' => 'required',
            'kelamin' => 'required',
            'stat_kawin' => 'required',
            'hub_kel' => 'required',
            'warga_neg' => 'required',
            'agama' => 'required',
            'pendidikan' => 'required',
            'pekerjaan' => 'required',
            'ayah' => 'required',
            'ibu' => 'required',
            'kepala_kel' => 'required',
            'no_hp' => 'required',
            'domisili' => 'required',
            'stat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }
        $save=Penduduk::where('id', $id)->update($req->all());
        if ($save) {
            return response()->json(['status'=>true,'massage'=>'sukses menambah siswa']);
        }
        else{
            return response()->json(['status'=>false,'massage'=>'gagal menambah siswa']);
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
