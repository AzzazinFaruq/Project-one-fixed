<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;

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
    public function index(){
        $dt = User::with('keluarga','penduduk',)->get();

        return response()->json($dt);
    }

    public function userUpdate(Request $request, $id) {

        $data = [
            'name' => $request->name,
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
}
