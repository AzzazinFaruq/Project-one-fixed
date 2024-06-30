<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
}
