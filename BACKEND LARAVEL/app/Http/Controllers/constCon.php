<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use config;

class constCon extends Controller
{
    public function index()
    {
        $constants = config('constants');

        return response()->json($constants);
    }
}
