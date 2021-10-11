<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class JabatanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $hasil = DB::select('select * from jabatan');
        return response()->json($hasil);
    }

    //
}
