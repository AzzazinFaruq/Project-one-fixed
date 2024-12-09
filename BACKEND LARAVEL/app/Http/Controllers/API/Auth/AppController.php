<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Penduduk;
use App\Models\keluarga;

class AppController extends Controller
{
    public function user(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'success' => true,
            'message' => 'Data user ' . $request->user()->name,
            'data' => $request->user(),
        ], 200);
    }
    public function index()
    {
        $dt = User::with('keluarga', 'penduduk',)->get();

        return response()->json($dt);
    }

    public function userUpdate(Request $request, $id)
    {

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'profile_picture' => $request->validated([
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:4096'
            ]),
            'updated_at' => now(),
        ];
        if ($request->hasFile('profile_picture')) {
            $profile_picture = $request->file('profile_picture');
            $filename = $profile_picture->getClientOriginalName();

            $profile_picture->move(public_path('uploads/profile_picture'), $filename);

            if (User::where('id', $id)->update($data)) {
                return [
                    'message' => 'Sukses',
                    'status' => 200,
                ];
            } else {
                return [
                    'message' => 'Gagal Update',
                    'status' => 400,
                ];
            }
        }
    }
    public function PassUpdate(Request $request, $id)
    {

        $data = [
            'password' => Hash::make($request->password),
            'updated_at' => now(),
        ];

        if (User::where('id', $id)->update($data)) {
            return [
                'message' => 'Sukses',
                'status' => 200,
            ];
        } else {
            return [
                'message' => 'Gagal Update',
                'status' => 400,
            ];
        }
    }
    public function userData(Request $request)
    {
        $id = $request->user()->id;
        $dtkel = keluarga::where('user_id', $id)->get();
        $dtpen = Penduduk::where('user_id', $id)->get();
        $hasilkel = $dtkel->reduce(
            function ($items, $data) {
                $stat = keluarga::stat($data->status);
                $items[] = [
                    'id' => $data->id,
                    'no_kk' => $data->no_kk,
                    'kk_nik' => $data->kk_nik,
                    'kk_nama' => $data->kk_nama,
                    'alamat' => $data->alamat,
                    'rt' => $data->rt,
                    'rw' => $data->rw,
                    'kode_pos' => $data->kode_pos,
                    'status' => $stat,
                    'user_id' => $data->user->id,
                    'user_name' => $data->user->name
                ];
                return $items;
            },
        );
        $hasils = $dtpen->reduce(
            function ($items, $data) {

                $agama = penduduk::agama($data->agama);
                $hub = penduduk::hub_kel($data->hub_kel);
                $stat_kwn = penduduk::stat_kawin($data->stat_kawin);
                $kelamin = penduduk::kelamin($data->kelamin);
                $pendidikan = penduduk::pendidikan($data->pendidikan);
                $pekerjaan = penduduk::pekerjaan($data->pekerjaan);
                $stat = penduduk::stat($data->stat);
                $warga = penduduk::warga_neg($data->warga_neg);


                $items[] = [
                    'id' => $data->id,
                    'kels_id' => $data->kels_id,
                    'nomer_kk' => $data->keluarga->no_kk,
                    'nik' => $data->nik,
                    'nama' => $data->nama,
                    'tmp_lhr' => $data->tmp_lhr,
                    'tgl_lhr' => $data->tgl_lhr,
                    'kelamin' => $kelamin,
                    'stat_kawin' => $stat_kwn,
                    'hub_kel' => $hub,
                    'warga_neg' => $warga,
                    'agama' => $agama,
                    'pendidikan' => $pendidikan,
                    'pekerjaan' => $pekerjaan,
                    'ayah' => $data->ayah,
                    'ibu' => $data->ibu,
                    'kepala_kel' => $data->keluarga->kk_nama,
                    'no_hp' => $data->no_hp,
                    'domisili' => $data->domisili,
                    'stat' => $stat,
                    'user_id' => $data->user->name
                ];
                return $items;
            },
        );

        return response()->json([
            'success' => true,
            'message' => 'Data user ' . $request->user()->name,
            'keluarga' => $hasilkel,
            'penduduk' => $hasils

        ], 200);
    }
    // public function byID($id){
    //     $dt= keluarga::where('id',$id)->get();

    //     return response()->json([
    //         'data' => $dt,
    //     ], 200);
    // }
}
